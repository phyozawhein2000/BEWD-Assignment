<?php
require_once '../config/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = trim($_POST['first_name'] ?? '');
    $lname = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $raw_password = $_POST['password'] ?? '';

    if (empty($fname) || empty($lname) || empty($email) || empty($raw_password)) {
        echo json_encode(['status' => 'error', 'message' => 'Required fields are missing.']);
        exit;
    }

    $hashed_password = password_hash($raw_password, PASSWORD_BCRYPT);

    try {
        $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->execute([$email]);
        
        if ($checkEmail->rowCount() > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Email is already taken!']);
        } else {
            $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$fname, $lname, $email, $hashed_password])) {
                echo json_encode(['status' => 'success', 'message' => 'Success! Redirecting to login...']);
            }
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'DB Error: ' . $e->getMessage()]);
    }
    exit;
}