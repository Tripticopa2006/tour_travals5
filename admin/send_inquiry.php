<?php
include('admin/db.php'); // Database connection include karein

if(isset($_POST['submit_inquiry'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
// Dashboard par inquiries count karne ke liye
$total_inquiries = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM inquiries"));
    $query = "INSERT INTO inquiries (name, email, subject, message) 
              VALUES ('$name', '$email', '$subject', '$message')";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Thank you! Your message has been sent.'); window.location.href='contact';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>