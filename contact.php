<?php include "header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Tour & Travels</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">

    <style>
/* REGISTER FORM STYLE MATCHING */
body {
    margin: 0; padding: 0;
    font-family: 'Montserrat', sans-serif;
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    color: #fff;
    min-height: 100vh;
}

.main-content {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 80px 0;
}

/* DARK CARD STYLE (Matching Register Image) */
.contact-card {
    background: rgba(18, 18, 18, 0.95); /* */
    border-radius: 30px;
    padding: 50px;
    width: 100%;
    max-width: 550px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.9);
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

/* CONTACT US HEADING - NOW WHITE */
.contact-card h2 {
    color: #ffffff; /* Requested: White color */
    font-weight: 800;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 5px;
}

.underline {
    height: 3px;
    width: 60px;
    background: #ffc107;
    margin: 12px auto 20px;
}

.sub-text {
    color: #ffc107; /* */
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 35px;
    letter-spacing: 1px;
}

/* INPUT STYLING - High Visibility Placeholders */
.form-control {
    background: rgba(255, 255, 255, 0.08) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: #ffffff !important;
    border-radius: 30px; 
    padding: 14px 25px;
    margin-bottom: 22px;
    font-size: 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.12) !important;
    border-color: #ffc107 !important;
    box-shadow: 0 0 10px rgba(255, 193, 7, 0.2);
    outline: none;
}

/* Placeholder Visibility Fix */
.form-control::placeholder {
    color: rgba(255, 255, 255, 0.8) !important; /* Brighter for visibility */
    font-weight: 500;
}

/* SEND MESSAGE BUTTON - GRADIENT + ICON */
.btn-send {
    background: linear-gradient(45deg, #ffc107, #ff9800); /* Vibrant button color */
    color: #000;
    border: none;
    padding: 14px;
    font-weight: 800;
    text-transform: uppercase;
    border-radius: 30px;
    width: 100%;
    margin-top: 15px;
    letter-spacing: 2px;
    transition: all 0.4s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-send i {
    font-size: 18px;
    margin-left: 10px; /* Requested: Icon on the side */
}

.btn-send:hover {
    background: linear-gradient(45deg, #ff9800, #ffc107);
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(255, 152, 0, 0.4);
}

.back-link {
    display: inline-block;
    margin-top: 25px;
    color: rgba(255, 255, 255, 0.5);
    text-decoration: none;
    font-size: 13px;
    transition: 0.3s;
}

.back-link:hover {
    color: #ffc107;
}
</style>
</head>

<body>

<div class="main-content">
    <div class="container d-flex justify-content-center">
        <div class="contact-card animate__animated animate__fadeInUp">
            <h2>CONTACT US</h2>
            <div class="underline"></div>
            <p class="sub-text">Start your journey with us</p>

            <form action="contact_process.php" method="POST">
                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                
                <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
                
                <input type="text" name="subject" class="form-control" placeholder="Subject " required>
                
                <textarea name="message" class="form-control" rows="4" placeholder="Your Message..." style="border-radius: 20px;"></textarea>

                <button type="submit" class="btn btn-send">
                    SEND MESSAGE <i class="fas fa-paper-plane"></i>
                </button>
            </form>

            <a href="index.php" class="back-link">← Back to Home</a>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>