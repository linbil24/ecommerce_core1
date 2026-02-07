<?php
// CustomerSupport/logout.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Clear only support session variables to avoid logging out of Admin portal
unset($_SESSION['support_logged_in']);
unset($_SESSION['support_id']);
unset($_SESSION['support_username']);
unset($_SESSION['support_role']);
unset($_SESSION['support_awaiting_otp']);
unset($_SESSION['temp_support_id']);
unset($_SESSION['temp_support_username']);

header("Location: login.php?msg=" . urlencode("Successfully logged out from Support Portal."));
exit();
?>
