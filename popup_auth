<?php
// Username and password (you can customize these)
$valid_username = 'som';
$valid_password = 'som';

// Check if the user has provided credentials
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
    || $_SERVER['PHP_AUTH_USER'] !== $valid_username
    || $_SERVER['PHP_AUTH_PW'] !== $valid_password) {

    // Send headers to prompt for login
    header('WWW-Authenticate: Basic realm="Restricted Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Authentication required.';
    exit;
}

?>?>
