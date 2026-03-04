<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$success = ''; $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['recipe_title']);
    $content = trim($_POST['recipe_content']);
    $user_id = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO community_cookbook (user_id, recipe_title, recipe_content) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $title, $content]);
        $success = "Your recipe was added to the Community Cookbook!";
    } catch (PDOException $e) {
        $error = "Database Error: " . $e->getMessage();
    }
}
?>

<div class="bg-stone-50 min-h-screen py-16">
    <div class="max-w-3xl mx-auto px-6">
        <div class="bg-white p-12 rounded-[3rem] shadow-xl border border-stone-100">
            <h1 class="text-3xl font-black text-emerald-800 mb-2 italic">Add to Cookbook</h1>
            <p class="text-stone-400 mb-10 font-medium">Share your culinary wisdom with the community.</p>

            <?php if($success): ?>
                <div class="bg-emerald-50 text-emerald-700 p-5 rounded-2xl mb-8 border border-emerald-100 font-bold">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-8">
                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Recipe Title</label>
                    <input type="text" name="recipe_title" required placeholder="e.g. Grandma's Secret Curry" 
                           class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-bold text-slate-700">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Recipe Content (Ingredients & Steps)</label>
                    <textarea name="recipe_content" rows="12" required placeholder="Describe your recipe here..." 
                              class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-medium text-slate-600"></textarea>
                </div>

                <button type="submit" class="w-full bg-emerald-800 text-white py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg">
                    Submit to Cookbook
                </button>
            </form>
        </div>
    </div>
</div>