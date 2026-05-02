<?php
// Session start karna zaroori hai taaki hum use access karke band kar sakein
session_start();

// Saare session variables ko khali (unset) kar dein
$_SESSION = array();

// Agar session cookies use ho rahi hain, toh unhe bhi delete karein
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Session ko puri tarah khatam (destroy) karein
session_destroy();

// Logout hone ke baad admin ko login page par bhej dein
header("Location: index.php");
exit;
?>