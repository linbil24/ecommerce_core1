<?php
/**
 * Cache Clear Utility
 * This script helps clear various caches and ensures fresh content delivery
 */

// Clear PHP opcode cache if available
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "✓ OPcache cleared\n";
}

// Clear any session data (optional - uncomment if needed)
// session_start();
// session_destroy();
// echo "✓ Session cleared\n";

// Set headers to prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

echo "✓ Cache headers set\n";
echo "✓ Cache clear complete!\n";
echo "\nPlease refresh your browser (Ctrl+F5 or Cmd+Shift+R)\n";
?>