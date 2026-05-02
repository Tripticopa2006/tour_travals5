<?php
// Session shuru karein taaki usse clear kar sakein
session_start();

// Saare session variables ko unset karein
session_unset();

// Session ko destroy karein
session_destroy();

// Home page par redirect karein
header("Location: index.php");
exit();
?>