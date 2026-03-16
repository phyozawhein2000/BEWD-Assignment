<?php
session_start();
require_once 'config/db.php';

if (isset($_SESSION['user_id']) && isset($_GET['comment_id'])) {
    $c_id = $_GET['comment_id'];
    $u_id = $_SESSION['user_id'];

    try {
        // ဘယ် Post က comment လဲဆိုတာ အရင်ရှာမယ်
        $find = $pdo->prepare("SELECT submission_id FROM cookbook_comments WHERE comment_id = ? AND user_id = ?");
        $find->execute([$c_id, $u_id]);
        $comment = $find->fetch();

        if ($comment) {
            $s_id = $comment['submission_id'];

            // 1. Comment ကို ဖျက်မယ်
            $pdo->prepare("DELETE FROM cookbook_comments WHERE comment_id = ?")->execute([$c_id]);

            // 2. Main table မှာ Comment count ကို -1 လျှော့မယ်
            $pdo->prepare("UPDATE community_cookbook SET totalComment = totalComment - 1 WHERE submission_id = ?")->execute([$s_id]);
        }
    } catch (PDOException $e) {}
}
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();