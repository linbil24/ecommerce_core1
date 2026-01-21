<?php
// Redirect to the new unified Payment page (same folder)
// Preserve all query parameters
$qs = $_SERVER['QUERY_STRING'];
header("Location: Payment.php" . ($qs ? "?" . $qs : ""));
exit();
?>


