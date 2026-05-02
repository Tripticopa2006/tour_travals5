<?php
session_start();
// Sirf ek baar sahi path include karein
include('admin/db.php'); 

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login");
    exit();
}

if (isset($_POST['confirm_booking'])) {
    $u_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
    $p_id = mysqli_real_escape_string($conn, $_POST['package_id']);
    $t_date = mysqli_real_escape_string($conn, $_POST['travel_date']);
    $persons = mysqli_real_escape_string($conn, $_POST['persons']);

    // Dhyaan dein: Table mein ye columns (travel_date, persons, status) hone chahiye
    $query = "INSERT INTO bookings (user_id, package_id, travel_date, persons, status) 
              VALUES ('$u_id', '$p_id', '$t_date', '$persons', 'Confirmed')";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Congratulations! Your booking is confirmed.');
                window.location.href='index'; 
              </script>";
    } else {
        // Agar column missing hoga toh yahan exact error dikhega
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    header("Location: index");
    exit();
}
?>