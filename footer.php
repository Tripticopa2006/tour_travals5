<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Attractive Footer</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* FOOTER MAIN */
.footer{
  background: linear-gradient(135deg,#1d2671,#c33764);
  color:#fff;
  padding:60px 0 20px;
  position:relative;
}

/* FOOTER HEADING */
.footer h5{
  font-weight:700;
  margin-bottom:20px;
}

/* LINKS */
.footer a{
  color:#ddd;
  text-decoration:none;
  display:block;
  margin-bottom:10px;
  transition:0.3s;
}

.footer a:hover{
  color:#ffc107;
  transform:translateX(5px);
}

/* ICON CIRCLE */
.footer-icon{
  width:40px;
  height:40px;
  background:#ffc107;
  color:#000;
  display:flex;
  align-items:center;
  justify-content:center;
  border-radius:50%;
  margin-right:10px;
  font-size:18px;
}

/* SOCIAL ICONS */
.social a{
  width:40px;
  height:40px;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  border-radius:50%;
  background:rgba(255,255,255,0.2);
  color:#fff;
  margin-right:10px;
  transition:0.3s;
  font-size:18px;
}

.social a:hover{
  background:#ffc107;
  color:#000;
  transform:translateY(-5px);
}

/* COPYRIGHT */
.footer-bottom{
  border-top:1px solid rgba(255,255,255,0.3);
  margin-top:40px;
  padding-top:15px;
  text-align:center;
  font-size:14px;
}
</style>
</head>

<body>

<footer class="footer">
  <div class="container">
    <div class="row g-4">

      <!-- ABOUT -->
      <div class="col-md-4">
        <h5>🌍 Tour & Travels</h5>
        <p>
          <b>Your Journey, Our Responsibility</b><br>
          India & International Tour Packages
        </p>
        <p>
          आपकी यात्रा, हमारी जिम्मेदारी<br>
          भारत और विदेश के बेहतरीन टूर पैकेज
        </p>
      </div>

      <!-- QUICK LINKS -->
      <div class="col-md-4">
        <h5>Quick Links</h5>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Packages</a>
        <a href="#">Gallery</a>
        <a href="#">Contact</a>
      </div>

      <!-- CONTACT -->
      <div class="col-md-4">
        <h5>Contact Info</h5>
        <p>📞 +91 9876543210</p>
        <p>📧 info@tourtravels.com</p>
        <p>📍 Your City, India</p>

        <div class="social mt-3">
          <a href="#">🌐</a>
          <a href="#">📘</a>
          <a href="#">📸</a>
          <a href="#">🐦</a>
        </div>
      </div>

    </div>

    <div class="footer-bottom mt-4">
      © 2026 Tour & Travels | All Rights Reserved
    </div>
  </div>
</footer>

</body>
</html>
