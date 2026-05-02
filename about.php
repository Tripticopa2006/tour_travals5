<?php include "header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌍 Tour & Travels</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">

    <style>
body {
    margin: 0; padding: 0;
    font-family: 'Montserrat', sans-serif;
    background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), 
                url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    color: #ffffff;
    overflow-x: hidden;
}

/* HERO SECTION */
.about-hero {
    padding: 100px 0 50px;
    text-align: center;
}
.about-hero h1 {
    font-size: 65px;
    font-weight: 800;
    letter-spacing: 4px;
    text-shadow: 0px 10px 20px rgba(0,0,0,0.5);
    background: linear-gradient(to right, #fff, #ffc107);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* MAIN ABOUT BOX */
.about-box {
    background: rgba(15, 15, 15, 0.85);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 40px;
    padding: 60px 45px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.5);
}

/* PREMIUM INFO CARDS */
.info-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 25px;
    padding: 35px 25px;
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    height: 100%;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.info-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,0,0,0.6);
    border: 1px solid rgba(255,255,255,0.3);
}

/* ICON COLORS */
.card-mountain i { color: #00d2ff; }
.card-mountain:hover { border-bottom: 5px solid #00d2ff; }
.card-waves i { color: #ff9966; }
.card-waves:hover { border-bottom: 5px solid #ff9966; }
.card-wild i { color: #2ecc71; }
.card-wild:hover { border-bottom: 5px solid #2ecc71; }
.card-price i { color: #f1c40f; }
.card-price:hover { border-bottom: 5px solid #f1c40f; }
.card-safety i { color: #e74c3c; }
.card-safety:hover { border-bottom: 5px solid #e74c3c; }
.card-soul i { color: #9b59b6; }
.card-soul:hover { border-bottom: 5px solid #9b59b6; }

.info-card i { font-size: 45px; margin-bottom: 20px; }
.info-card h6 { font-size: 22px; font-weight: 800; margin-bottom: 5px; color: #ffffff; }

/* Subtitle for Hindi Translation */
.lang-hi {
    display: block;
    font-size: 14px;
    color: #ffc107;
    margin-bottom: 15px;
    font-weight: 500;
}

.info-card p {
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
    line-height: 1.5;
}

/* STATS SECTION */
.stat-item i { color: #ffc107; font-size: 24px; margin-bottom: 10px; }
.stat-number {
    font-size: 42px; font-weight: 800; display: block;
    background: linear-gradient(to bottom, #ffc107, #ff9800);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
}

.btn-explore {
    background: linear-gradient(45deg, #ffc107, #ff9800);
    color: #000; font-weight: 800; padding: 18px 45px;
    border-radius: 50px; text-decoration: none; transition: 0.3s;
    display: inline-block; box-shadow: 0 10px 20px rgba(255, 193, 7, 0.3);
}
.btn-explore:hover { transform: translateY(-3px); background: #fff; color: #000; }
</style>
</head>

<body>

<section class="about-hero animate__animated animate__fadeIn">
    <div class="container">
        <h1>EXPLORE NATURE</h1>
        <p style="color: #ffc107; font-weight: 700; font-size: 24px;">Home Away From Home <br> <span style="font-size: 18px;">(घर से दूर एक और घर)</span></p>
    </div>
</section>

<section class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="about-box text-center animate__animated animate__zoomIn">
                <h3 style="color: #ffc107;" class="mb-4 fw-bold">🌍 Our Story </h3>
                <p style="font-size: 19px; line-height: 1.8; color: #ddd;">
                    Welcome to <b>Tour & Travels</b>. We don't just sell packages; we create <b>life-changing experiences</b>. 
                    Whether you're looking for the adrenaline of the mountains or the serenity of the sea, 
                    our mission is to provide you with a journey that touches your soul.<br>
                    <span style="color: #ffc107; font-size: 17px; display: block; mt-2;">
                    टूर एंड ट्रेवल्स में आपका स्वागत है। हम केवल पैकेज नहीं बेचते; हम जीवन बदल देने वाले अनुभव बनाते हैं। 
                    चाहे आप पहाड़ों का रोमांच चाहते हों या समुद्र की शांति, हमारा लक्ष्य आपको एक ऐसी यात्रा प्रदान करना है जो आपकी आत्मा को छू ले।
                    </span>
                </p>
                
                <div class="row mt-5 py-4 g-4" style="background: rgba(255,255,255,0.03); border-radius: 25px;">
                    <div class="col-md-4 stat-item">
                        <i class="fas fa-heart"></i>
                        <span class="stat-number">10k+</span>
                        <p class="small text-uppercase fw-bold text-white-50">Happy Souls </p>
                    </div>
                    <div class="col-md-4 stat-item border-start border-end border-secondary border-opacity-25">
                        <i class="fas fa-map-marked-alt"></i>
                        <span class="stat-number">150+</span>
                        <p class="small text-uppercase fw-bold text-white-50">Destinations </p>
                    </div>
                    <div class="col-md-4 stat-item">
                        <i class="fas fa-award"></i>
                        <span class="stat-number">12+</span>
                        <p class="small text-uppercase fw-bold text-white-50">Years of Trust </p>
                    </div>
                </div>

                <div class="mt-5">
                    <a href="packages.php" class="btn-explore">Start Your Adventure / सफर शुरू करें <i class="fas fa-paper-plane ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container mb-5 pb-5">
    <div class="row g-4 text-center">
        <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
            <div class="info-card card-mountain">
                <i class="fas fa-mountain"></i>
                <h6>Mountain Peaks</h6>
                <span class="lang-hi">पर्वत की चोटियाँ</span>
                <p>Conquer the heights with our expert Himalayan trekking guides.<br>हमारे विशेषज्ञ हिमालयन ट्रेकिंग गाइड्स के साथ ऊंचाइयों को फतह करें।</p>
            </div>
        </div>
        <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
            <div class="info-card card-waves">
                <i class="fas fa-water"></i>
                <h6>Ocean Waves</h6>
                <span class="lang-hi">समुद्र की लहरें</span>
                <p>Feel the salt in the air and the sand in your toes at exotic beaches.<br>विदेशी समुद्र तटों पर हवा में नमक और पैरों में रेत का आनंद लें।</p>
            </div>
        </div>
        <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
            <div class="info-card card-wild">
                <i class="fas fa-leaf"></i>
                <h6>Wild Forest</h6>
                <span class="lang-hi">जंगली जंगल</span>
                <p>Explore the deep mysteries of the jungle with safe wildlife safaris.<br>सुरक्षित वन्यजीव सफारी के साथ जंगल के गहरे रहस्यों का पता लगाएं।</p>
            </div>
        </div>
        <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
            <div class="info-card card-price">
                <i class="fas fa-tags"></i>
                <h6>Best Prices</h6>
                <span class="lang-hi">सबसे अच्छी कीमतें</span>
                <p>Luxury travel doesn't have to be expensive. Quality at the best rates.<br>लक्जरी यात्रा महंगी होने की जरूरत नहीं है। बेहतरीन दरों पर गुणवत्ता।</p>
            </div>
        </div>
        <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
            <div class="info-card card-safety">
                <i class="fas fa-user-check"></i>
                <h6>Safe Travel</h6>
                <span class="lang-hi">सुरक्षित यात्रा</span>
                <p>Your safety is our priority. 24/7 on-ground support for all trips.<br>आपकी सुरक्षा हमारी प्राथमिकता है। सभी यात्राओं के लिए 24/7 सहायता।</p>
            </div>
        </div>
        <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
            <div class="info-card card-soul">
                <i class="fas fa-om"></i>
                <h6>Soulful Trips</h6>
                <span class="lang-hi">आध्यात्मिक यात्रा</span>
                <p>Spiritual and meditation retreats to find your inner peace.<br>अपनी आंतरिक शांति पाने के लिए आध्यात्मिक और ध्यान यात्राएं।</p>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>


</body>
</html>