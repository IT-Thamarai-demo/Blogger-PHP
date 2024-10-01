<?php
// Start the session
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect the user to the login page or homepage
header("Location: login.php");
exit();
?>
