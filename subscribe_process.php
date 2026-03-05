<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO subscribers (email) VALUES (?)");
        $stmt->execute([$email]);
        echo json_encode(['status' => 'success', 'message' => 'Successfully joined the table!']);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry error
            echo json_encode(['status' => 'error', 'message' => 'You are already subscribed.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong. Try again.']);
        }
    }
}
?>