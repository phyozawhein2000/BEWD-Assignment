<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: auth/login.php"); exit;
}

$u_id = $_SESSION['user_id'];
$s_id = $_GET['id'];

try {
    $check = $pdo->prepare("SELECT like_id FROM cookbook_likes WHERE submission_id = ? AND user_id = ?");
    $check->execute([$s_id, $u_id]);

    if ($check->fetch()) {
        $pdo->prepare("DELETE FROM cookbook_likes WHERE submission_id = ? AND user_id = ?")->execute([$s_id, $u_id]);
        $pdo->prepare("UPDATE community_cookbook SET totalLike = totalLike - 1 WHERE submission_id = ?")->execute([$s_id]);
    } else {
        $pdo->prepare("INSERT INTO cookbook_likes (submission_id, user_id) VALUES (?, ?)")->execute([$s_id, $u_id]);
        $pdo->prepare("UPDATE community_cookbook SET totalLike = totalLike + 1 WHERE submission_id = ?")->execute([$s_id]);
    }
} catch (Exception $e) {}

header("Location: view_community_recipe.php?id=" . $s_id);