<?php 
// Session check karein
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Current page ka naam nikalne ka sabse asaan tarika
$current_page = basename($_SERVER['PHP_SELF']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌍 Tour & Travels - Navigation</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* NAVBAR MAIN STYLE */
        .navbar { 
            background: linear-gradient(135deg,#1d2671,#c33764); 
            padding: 12px 0; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand { 
            font-size: 26px; 
            font-weight: 800; 
            color: #fff !important; 
            letter-spacing: 1px; 
        }

        .nav-link { 
            color: rgba(255,255,255,0.8) !important; 
            margin: 0 5px; 
            font-size: 15px; 
            font-weight: 500; 
            padding: 8px 18px !important;
            border-radius: 50px; /* Round corners for highlight */
            transition: all 0.3s ease;
        }

        /* HOVER EFFECT */
        .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.1);
        }

        /* 🟢 ACTIVE PAGE HIGHLIGHT 🟢 */
        /* Jab user kisi page par hoga, ye style dikhega */
        .nav-link.active { 
            color: #000 !important; /* Text ka color black/dark */
            background-color: #ffc107 !important; /* Pila background highlight */
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        /* CONTACT & LOGOUT BUTTON (Hamesha highlight rahega) */
        .btn-contact { 
            background: #ffc107 !important; 
            color: #000 !important; 
            border: none;
            margin-left: 10px;
        }

        .btn-contact:hover {
            background: #fff !important;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">🌍 Tour & Travals</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : ''; ?>" href="index.php">Home</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="about.php">About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'packages.php') ? 'active' : ''; ?>" href="packages.php">Packages</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'gallery.php') ? 'active' : ''; ?>" href="gallery.php">Gallery</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>" href="contact.php">Contact</a>
        </li>
             <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'offers.php') ? 'active' : ''; ?>" href="offers.php">offers</a>
        </li>

          

        <?php if(isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'user_dashboard.php') ? 'active' : ''; ?>" href="user_dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-contact" href="logout.php">Logout</a>
            </li>
        
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'user_register.php') ? 'active' : ''; ?>" href="user_register.php">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page == 'user_login.php') ? 'active' : ''; ?>" href="user_login.php">Login</a>
            </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>