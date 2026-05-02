<?php 
include "header.php"; 
$db_name = "tour_travals"; 
$conn = mysqli_connect("localhost", "root", "", $db_name);

if(isset($_GET['package_id'])) {
    $p_id = intval($_GET['package_id']);
    $p_res = mysqli_query($conn, "SELECT p_name FROM packages WHERE id = $p_id");
    $p_data = mysqli_fetch_assoc($p_res);
} else {
    header("Location: gallery.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $p_data['p_name']; ?> | Nature Gallery</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body { 
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff; 
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
        }

        /* Yahan se bada black box (main-card) hata diya gaya hai */
        .gallery-wrapper {
            padding: 60px 0;
        }

        .heading-style {
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: #ffc107;
            text-shadow: 3px 3px 15px rgba(0,0,0,0.8);
        }

        .gallery-item { 
            border-radius: 15px; 
            overflow: hidden; 
            height: 260px; 
            border: 2px solid rgba(255, 255, 255, 0.1); 
            transition: 0.4s ease-in-out; 
            background: rgba(0,0,0,0.3); /* Chote box ka halka background */
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }

        .gallery-item img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            transition: transform 0.6s;
        }

        .gallery-item:hover { 
            border-color: #ffc107; 
            transform: scale(1.05);
            box-shadow: 0 15px 35px rgba(255, 193, 7, 0.3);
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .back-btn { 
            background: #ffc107; 
            color: #000; 
            font-weight: 700; 
            border-radius: 50px; 
            padding: 12px 35px; 
            text-decoration: none; 
            display: inline-block; 
            transition: 0.3s;
            margin-bottom: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .back-btn:hover { 
            background: #fff; 
            transform: translateX(-5px);
        }

        .hindi-sub {
            color: #ffc107;
            font-size: 1.2rem;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .album-name {
            background: rgba(255, 193, 7, 0.1);
            padding: 5px 20px;
            border-radius: 10px;
            display: inline-block;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
    </style>
</head>
<body>

<div class="container gallery-wrapper">
    <a href="gallery.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Gallery</a>
    
    <div class="text-center mb-5">
        <h1 class="heading-style display-4">EXPLORE NATURE</h1>
        <p class="mb-1 fw-bold fs-5">Home Away From Home</p>
        <p class="hindi-sub">(घर से दूर एक और घर)</p>
        
        <div class="mt-4">
            <h4 class="album-name">Album: <span class="text-warning"><?php echo $p_data['p_name']; ?></span></h4>
        </div>
        <hr style="width: 80px; margin: 25px auto; border-top: 4px solid #ffc107; border-radius: 2px;">
    </div>

    <div class="row g-4 justify-content-center">
        <?php
        $g_res = mysqli_query($conn, "SELECT image_path FROM gallery WHERE package_id = $p_id ORDER BY id DESC");

        if(mysqli_num_rows($g_res) > 0) {
            while($g_row = mysqli_fetch_assoc($g_res)) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="gallery-item">
                        <img src="admin/<?php echo $g_row['image_path']; ?>" class="img-fluid" alt="Tour View">
                    </div>
                </div>
            <?php }
        } else {
            echo "<div class='col-12 text-center py-5'><h3 class='text-white-50'>No photos found in this album.</h3></div>";
        }
        ?>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>