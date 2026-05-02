<?php 
include "header.php"; 
// Database Connection
$db_name = "tour_travals"; 
$conn = mysqli_connect("localhost", "root", "", $db_name);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🌍 Travel Gallery | Tour & Travals</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            margin: 0; padding: 0; font-family: 'Montserrat', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-position: center; background-attachment: fixed;
            color: #fff; overflow-x: hidden;
        }
        .gallery-title { font-size: 55px; font-weight: 800; text-align: center; text-transform: uppercase; letter-spacing: 3px; text-shadow: 3px 5px 15px rgba(0,0,0,0.7); margin-bottom: 10px; color: #ffffff; }
        .text-gold { color: #ffc107 !important; font-weight: 700; }
        .gallery-box { border-radius: 30px; overflow: hidden; position: relative; border: 2px solid rgba(255, 255, 255, 0.2); box-shadow: 0 15px 35px rgba(0,0,0,0.5); transition: 0.5s ease; background: rgba(0,0,0,0.5); display: block; text-decoration: none !important; }
        .gallery-box img { width: 100%; height: 300px; object-fit: cover; transition: 0.8s ease; display: block; }
        .gallery-box .overlay { position: absolute; inset: 0; background: rgba(0, 0, 0, 0.5); display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; transition: 0.4s ease; backdrop-filter: blur(4px); }
        .gallery-box .overlay h3 { color: #fff; font-weight: 700; text-transform: uppercase; margin-bottom: 15px; transform: translateY(-20px); transition: 0.4s ease; }
        .gallery-box .overlay span { background: #ffc107; color: #000; padding: 12px 25px; border-radius: 50px; font-weight: 800; font-size: 14px; text-transform: uppercase; transform: translateY(30px); transition: 0.4s ease; }
        .gallery-box:hover { transform: translateY(-15px); border-color: #ffc107; }
        .gallery-box:hover img { transform: scale(1.1); }
        .gallery-box:hover .overlay { opacity: 1; }
        .gallery-box:hover .overlay h3, .gallery-box:hover .overlay span { transform: translateY(0); }
    </style>
</head>
<body>

<div class="container my-5 py-5">
    <section class="text-center mb-5 animate__animated animate__fadeInDown">
        <h1 class="gallery-title">📸 Travel Gallery</h1>
        <p class="text-gold" style="font-size: 20px;">Explore our world-class tour packages</p>
    </section>

    <div class="row g-4">
        <?php
        // Packages fetch kar rahe hain
        $query = "SELECT id, p_name, p_image FROM packages ORDER BY id DESC";
        $res = mysqli_query($conn, $query);

        if(mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) { ?>
                <div class="col-lg-4 col-md-6 animate__animated animate__zoomIn">
                    <a href="view_gallery.php?package_id=<?php echo $row['id']; ?>" class="gallery-box">
                        <img src="admin/uploads/<?php echo $row['p_image']; ?>" alt="<?php echo $row['p_name']; ?>">
                        <div class="overlay">
                            <h3><?php echo $row['p_name']; ?></h3>
                            <span>View Gallery <i class="fas fa-camera ms-1"></i></span>
                        </div>
                    </a>
                </div>
            <?php } 
        } else {
            echo "<h3 class='text-center'>No Packages Found!</h3>";
        } ?>
    </div>
</div>

<?php include "footer.php"; ?>
</body>
</html>