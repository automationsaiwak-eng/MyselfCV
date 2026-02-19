<?php
/**
 * contact.php – Contact form handler
 * Accepts both AJAX (JSON) and regular POST requests.
 * Saves messages to the messages table.
 */

session_start();
require_once 'config/db.php';

$isAjax = isset($_POST['ajax']) && $_POST['ajax'] === '1';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim(strip_tags($_POST['name']    ?? ''));
    $email   = trim(strip_tags($_POST['email']   ?? ''));
    $subject = trim(strip_tags($_POST['subject'] ?? ''));
    $message = trim(strip_tags($_POST['message'] ?? ''));

    // Validation
    $errors = [];
    if (!$name)    $errors[] = 'Name is required.';
    if (!$email)   $errors[] = 'Email is required.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';
    if (!$subject) $errors[] = 'Subject is required.';
    if (!$message) $errors[] = 'Message is required.';

    if (!empty($errors)) {
        sendResponse($isAjax, false, implode(' ', $errors));
        exit;
    }

    try {
        $db = getDB();
        $stmt = $db->prepare(
            'INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$name, $email, $subject, $message]);
        sendResponse($isAjax, true, 'Message sent successfully!');
    } catch (PDOException $e) {
        error_log('Contact form error: ' . $e->getMessage());
        sendResponse($isAjax, false, 'Server error. Please try again later.');
    }
    exit;
}

// Non-POST request -> redirect home
header('Location: index.php#contact');
exit;

function sendResponse(bool $isAjax, bool $success, string $message): void {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success, 'message' => $message]);
    } else {
        $_SESSION['contact_' . ($success ? 'success' : 'error')] = $message;
        header('Location: index.php#contact');
    }
    
}

