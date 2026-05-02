<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendMail($to, $subject, $message)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dubeytripti436@gmail.com';
        $mail->Password = 'fhhkhsawpvcsdyks'; // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender
        $mail->setFrom('dubeytripti436@gmail.com', 'Tour Travels');

        // Receiver
        $mail->addAddress($to);

        // Mail Content - HTML ENABLE KAREIN
        $mail->isHTML(true); // <--- YE LINE ZAROORI HAI
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        return true;

    } catch (Exception $e) {
        return $mail->ErrorInfo;
    }
}
?>