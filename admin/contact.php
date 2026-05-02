<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>🌍 Tour & Travals</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
  background: linear-gradient(135deg,#667eea,#764ba2);
  min-height:100vh;
}
.contact-box{
  background:#fff;
  padding:30px;
  border-radius:20px;
  box-shadow:0 15px 40px rgba(0,0,0,0.3);
}
</style>
</head>

<body>
  <form action="send_inquiry.php" method="POST">
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="text" name="subject" placeholder="Subject">
    <textarea name="message" placeholder="Write your message here..." required></textarea>
    <button type="submit" name="submit_inquiry">Send Message</button>
</form>
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh">

<div class="contact-box col-md-6">
  <h3 class="text-center mb-4">📞 Contact Us</h3>

  <p><b>Company:</b> Tours & Travels</p>
  <p><b>Email:</b> tourstravels@gmail.com</p>
  <p><b>Phone:</b> +91 9876543210</p>
  <p><b>Address:</b> New Delhi, India</p>

  <a href="dashboard.php" class="btn btn-primary w-100 mt-3">Back to Dashboard</a>
</div>

</div>
</body>
</html>
