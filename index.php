<?php 
// 1. Session aur Database connection start karein
session_start();

// Database connection file check karein
if(file_exists('admin/db.php')){
    include ('admin/db.php'); 
} else {
    die("Error: Database configuration file (admin/db.php) not found!");
}

// 2. Database se latest packages fetch karein
$query = "SELECT * FROM packages ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Header file include karein
include "header.php"; 
?>

<style>
    /* Pure page ka background pahad aur ped wala setup */
    body {
        background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), 
                    url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80'); 
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
    }

    /* Pehle Jaisa Compact Slider CSS */
    .slider-wrapper { 
        width: 100%; 
        margin: 0; 
        padding: 0;
        overflow-x: hidden;
    }
    
    .slider { 
        position: relative; 
        width: 100%; 
        height: 60vh; 
        overflow: hidden; 
        background: #000;
    }

    .slide { 
        display: none; 
        width: 100%; 
        height: 100%; 
        position: absolute; 
    }
    
    .slide.active { 
        display: block; 
        animation: fade 1s ease-in-out; 
    } 
    
    .slide img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
    }

    @keyframes fade { 
        from { opacity: 0.5; } 
        to { opacity: 1; } 
    }

    /* Pehle wale Navigation Buttons */
    .prev, .next { 
        position: absolute; 
        top: 50%; 
        transform: translateY(-50%); 
        font-size: 24px; 
        color: white; 
        background: rgba(0,0,0,0.3); 
        padding: 12px 18px; 
        cursor: pointer; 
        z-index: 10;
        transition: 0.3s;
        text-decoration: none;
        user-select: none;
        border-radius: 5px;
        margin: 0 10px;
    }
    
    .next { right: 0; }
    .prev { left: 0; }
    .prev:hover, .next:hover { background: rgba(0,0,0,0.8); }

    /* Pehle wala Text Overlay */
    .text { 
        position: absolute; 
        bottom: 15%; 
        left: 5%; 
        background: rgba(0,0,0,0.6); 
        color: white; 
        padding: 20px 25px; 
        border-radius: 12px;
        max-width: 450px;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .text h2 { font-size: 2rem; font-weight: 700; margin-bottom: 5px; }
    .text p { font-size: 1rem; margin: 0; opacity: 0.9; }

    /* Package Section Glass Look */
    #packages {
        padding: 60px 0;
    }

    .section-title {
        color: #fff;
        font-weight: 800;
        font-size: 2.5rem;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
        margin-bottom: 40px;
    }

    .card { 
        transition: all 0.3s ease; 
        border-radius: 15px; 
        overflow: hidden; 
        border: none;
        background: rgba(255, 255, 255, 0.95);
    }
    
    .card:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 12px 25px rgba(0,0,0,0.2) !important;
    }

    @media (max-width: 768px) {
        .slider { height: 40vh; }
        .text { bottom: 10%; padding: 15px; max-width: 80%; }
        .text h2 { font-size: 1.4rem; }
    }
</style>

<div class="slider-wrapper">
    <div class="slider">
        <div class="slide active">
            <img src="images/travels3.jpg" alt="Beaches"> 
            <div class="text">
                <h2>Beautiful Beaches</h2>
                <p>Relax & Enjoy the waves in luxury</p>
            </div>
        </div>

        <div class="slide">
            <img src="images/travels4.jpg" alt="Mountains">
            <div class="text">
                <h2>Mountain Adventures</h2>
                <p>Explore the heights of pure nature</p>
            </div>
        </div>

        <div class="slide">
            <img src="images/travels 1.jpg" alt="International">
            <div class="text">
                <h2>International Tours</h2>
                <p>Premium travel experiences across the globe</p>
            </div>
        </div>

        <span class="prev">&#10094;</span>
        <span class="next">&#10095;</span>
    </div>
</div>

<section id="packages">
    <div class="container">
        <h2 class="text-center section-title">Our Popular Packages</h2>
        
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php 
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $title = $row['p_name'] ?? $row['title'] ?? 'Travel Package';
                    $desc  = $row['p_description']  ?? $row['description'] ?? 'No Description Available';
                    $price = $row['p_price'] ?? $row['price'] ?? '0';
                    $image = $row['p_image'] ?? $row['image'] ?? 'default.jpg';
                    $id    = $row['id'];

                    if (!isset($_SESSION['user_id'])) {
                        $target_url = "user_login.php?package_id=" . $id;
                    } else {
                        $target_url = "booking_process.php?id=" . $id;
                    }
            ?>
            
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="admin/uploads/<?php echo $image; ?>" class="card-img-top" alt="Package" style="height: 250px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold" style="color: #001f3f;"><?php echo $title; ?></h5>
                        <p class="card-text text-muted" style="font-size: 0.95rem;"><?php echo substr($desc, 0, 120); ?>...</p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fs-4 fw-bold text-primary">₹<?php echo number_format((float)$price); ?></span>
                            <a href="<?php echo $target_url; ?>" class="btn btn-dark px-4 rounded-pill shadow-sm">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php 
                } 
            } else {
                echo "<div class='col-12 text-center'><p class='alert alert-warning'>No packages found!</p></div>";
            }
            ?>
        </div>
    </div>
</section>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll(".slide");

    function showSlide(n) {
        if (slides.length === 0) return;
        slides.forEach(s => {
            s.classList.remove("active");
            s.style.display = "none";
        });
        currentSlide = (n + slides.length) % slides.length;
        slides[currentSlide].style.display = "block";
        setTimeout(() => {
            slides[currentSlide].classList.add("active");
        }, 20);
    }

    document.querySelector(".next").addEventListener("click", () => showSlide(currentSlide + 1));
    document.querySelector(".prev").addEventListener("click", () => showSlide(currentSlide - 1));

    let slideInterval = setInterval(() => showSlide(currentSlide + 1), 3000);

    const sliderContainer = document.querySelector(".slider");
    sliderContainer.addEventListener("mouseenter", () => clearInterval(slideInterval));
    sliderContainer.addEventListener("mouseleave", () => {
        slideInterval = setInterval(() => showSlide(currentSlide + 1), 3000);
    });
</script>

<?php include "footer.php"; ?>