<?php
include('admin/db.php');

if(isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Database mein email check karein
    $query = "SELECT * FROM users WHERE email='$email'";
    $results = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($results) > 0) {
        // Agar email mil gaya toh 'exists' bhejenge
        echo "exists";
    } else {
        // Agar nahi mila toh 'available'
        echo "available";
    }
}
?>