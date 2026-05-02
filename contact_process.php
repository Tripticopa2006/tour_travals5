<?php
session_start();

include "admin/db.php"; 
include "admin/mail_config.php"; // Isme aapka sendMail() function hai

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $phone   = mysqli_real_escape_string($conn, $_POST['phone']); 
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // 1. DATABASE INSERT
    $sql = "INSERT INTO inquiries (name, email, phone, subject, message) 
            VALUES ('$name', '$email', '$phone', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {
        
        // 2. EMAIL CONTENT
        $mailSubject = "New Inquiry: $subject";
        $mailBody = "
            <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #eee;'>
                <h2 style='color: #2c3e50;'>Inquiry Confirmation</h2>
                <p>Hello $name, we have received your message.</p>
                <p><strong>Subject:</strong> $subject</p>
                <p><strong>Message:</strong> $message</p>
            </div>";

        // 3. MAIL SENDING WITH ERROR CHECKING
        $result = sendMail($email, $mailSubject, $mailBody);

        if ($result === true) {
            // Mail chali gayi
            echo "<script>
                    alert('Success! Data saved and Email sent.');
                    window.location.href='contact.php';
                  </script>";
        } else {
            // Mail nahi gayi, error dikhayein (Database mein data save ho chuka hai)
            echo "<script>
                    alert('Data saved but Mail Error: " . addslashes($result) . "');
                    window.location.href='contact.php';
                  </script>";
        }

    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    header("Location: contact.php");
    exit();
}
?>