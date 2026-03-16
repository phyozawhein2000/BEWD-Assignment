<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $s_id = $_POST['submission_id'];
    $u_id = $_SESSION['user_id'];
    $text = trim($_POST['comment']); // Form က name နဲ့ ကိုက်အောင် စစ်ပါ

    if (!empty($text)) {
        try {
            // 1. Comment ကို အရင်သိမ်းမယ်
            $stmt = $pdo->prepare("INSERT INTO cookbook_comments (submission_id, user_id, comment) VALUES (?, ?, ?)");
            $stmt->execute([$s_id, $u_id, $text]);

            // 2. Main table မှာ Comment count ကို +1 တိုးမယ်
            $updateStmt = $pdo->prepare("UPDATE community_cookbook SET totalComment = totalComment + 1 WHERE submission_id = ?");
            $updateStmt->execute([$s_id]);

        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    header("Location: view_community_recipe.php?id=" . $s_id);
    exit();
}