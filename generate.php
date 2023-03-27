<?php

require_once 'config.php';

// Set the response content type to JSON
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

// Check if the URL parameter is present
if (!isset($_POST['url'])) {
    echo json_encode(['success' => false, 'error' => 'Missing URL parameter']);
    exit;
}

// Get the URL parameter from the AJAX request
$url = $_POST['url'];

// Validate the URL
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    echo json_encode(['success' => false, 'error' => 'Invalid URL']);
    exit;
}



// Generate a unique short code and check if it doesn't already exist in the database
function generateShortCode()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length = 6;
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}

// Check if a short code already exists in the database
function shortCodeExists($pdo, $short_code)
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM short_urls WHERE short_code = ?');
    $stmt->execute([$short_code]);
    return (bool) $stmt->fetchColumn();
}

function insertUrl($pdo, $url, $short_code, $expiry_time)
{
    if ($expiry_time) {
        $expiry_date = date('Y-m-d H:i:s', strtotime($expiry_time));
    } else {
        $expiry_date = '9999-12-31 23:59:59'; // Set a far future date for no expiry
    }
    $stmt = $pdo->prepare('INSERT INTO short_urls (long_url, short_code, expiry_date) VALUES (?, ?, ?)');
    $stmt->execute([$url, $short_code, $expiry_date]);
}





// Generate a unique short code and check if it doesn't already exist in the database
$short_code = generateShortCode();
while (shortCodeExists($pdo, $short_code)) {
    $short_code = generateShortCode();
}

// Get the expiry time from the user input or default to 24 hours
$expiry = $_POST['expiry'];
switch ($expiry) {
    case '1hr':
        $expiry_time = '+1 hour';
        break;
    case '10hr':
        $expiry_time = '+10 hours';
        break;
    case '24hr':
        $expiry_time = '+24 hours';
        break;
    case '1wk':
        $expiry_time = '+1 week';
        break;
    case '1mo':
        $expiry_time = '+1 month';
        break;
    case '0':
        // No expiry time specified, set expiry date to null
        $expiry_time = null;
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid expiry time']);
        exit;
}

// Insert the URL and short code into the database with the specified expiry time
insertUrl($pdo, $url, $short_code, $expiry_time);

// Return the short URL as a response to the AJAX request
$short_url = SYSTEM_URL . '/u/' . $short_code;
echo json_encode(['success' => true, 'short_url' => $short_url]);
