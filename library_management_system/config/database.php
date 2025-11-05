<?php
// Update credentials for your XAMPP/LAMP/WAMP
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = ''; // set your password if any
$DB_NAME = 'library_db';

$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die('Database connection failed: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
?>
