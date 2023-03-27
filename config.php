<?php
// Define database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'shortify');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// Define base URL
define('SYSTEM_URL', 'http://url-shortener-with-expiry.test');

// Establish PDO database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
    // Redirect to installation page if there was an error connecting to the database
    header("Location: /install");
    exit();
}
