<?php
// Set the response content type to plain text
header('Content-Type: text/plain');

// Check if the short code parameter is present in the URL
if (!isset($_GET['code'])) {
    http_response_code(400);
    die('Missing short code parameter');
}

// Get the short code parameter from the URL
$short_code = $_GET['code'];

// Validate the short code
if (!preg_match('/^[a-zA-Z0-9]{6}$/', $short_code)) {
    http_response_code(400);
    die('Invalid short code');
}

require_once 'config.php';

// Look up the URL associated with the short code in the database
$stmt = $pdo->prepare('SELECT long_url FROM short_urls WHERE short_code = ? AND expiry_date > NOW()');
$stmt->execute([$short_code]);
$url = $stmt->fetchColumn();

// If no URL is found, display an error message
if (!$url) {
    http_response_code(404);
    die('Invalid short code or expired URL');
}

// Redirect to the original URL
header("Location: $url");
