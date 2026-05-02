<?php
session_start();
include "db.php";

if(isset($_POST['login'])){
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // check admin table empty or not
    $check = mysqli_query($conn,"SELECT * FROM admin");

    if(mysqli_num_rows($check) == 0){
        // FIRST TIME → INSERT
        $insert = mysqli_query($conn,
          "INSERT INTO admin(username,password)
           VALUES('$user','$pass')"
        );

        if($insert){
            $_SESSION['admin'] = $user;
            header("Location: dashboard.php");
            exit();
        }else{
            $error = "Insert Failed";
        }

    }else{
        // LOGIN CHECK
        $login = mysqli_query($conn,
          "SELECT * FROM admin
           WHERE username='$user' AND password='$pass'"
        );

        if(mysqli_num_rows($login)==1){
            $_SESSION['admin'] = $user;
            header("Location: dashboard.php");
            exit();
        }else{
            $error = "Invalid Username or Password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>🌍 Tour & Travals</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
  background: radial-gradient(circle at center, #001f3f 0%, #000814 100%);
  height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  margin: 0;
}
.login-box{
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(15px);
  padding: 30px 25px;
  border-radius: 25px;
  width: 100%;
  max-width: 300px; /* Chota compact box */
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 20px 40px rgba(0,0,0,0.5);
  text-align: center;
}
.form-control {
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: white !important;
  border-radius: 50px;
  text-align: center;
  font-size: 14px;
}
.form-control::placeholder {
  color: rgba(255,255,255,0.4);
}
.form-control:focus {
  background: rgba(255, 255, 255, 0.15);
  border-color: #22d3ee;
  box-shadow: none;
}
.btn-admin {
  background: #0891b2;
  border: none;
  border-radius: 50px;
  font-weight: bold;
  text-transform: uppercase;
  font-size: 12px;
  letter-spacing: 1px;
}
.btn-admin:hover {
  background: #22d3ee;
}
.home-link {
  display: block;
  margin-top: 15px;
  font-size: 11px;
  color: rgba(255,255,255,0.5);
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 1px;
}
.home-link:hover {
  color: #22d3ee;
}
</style>
</head>

<body>

<div class="login-box">
    <div style="background: rgba(34, 211, 238, 0.1); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
        <span style="font-size: 18px;">🔐</span>
    </div>
    <h2 style="color: white; font-size: 16px; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 20px;">Admin</h2>

    <?php if(isset($error)){ ?>
        <p style="color: #f87171; font-size: 10px; margin-bottom: 15px;">⚠️ <?php echo $error; ?></p>
    <?php } ?>

    <form method="post">
        <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        <button name="login" class="btn btn-admin w-100 text-white">Login</button>
    </form>

    <a href="../index.php" class="home-link">← Back to Home</a>

</div>

</body>
</html>