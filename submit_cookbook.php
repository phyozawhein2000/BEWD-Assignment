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
    $image_name = 'default_recipe.jpg'; // ပုံမတင်ရင် သုံးမယ့် default name

    // --- Image Upload Logic ---
    if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] === 0) {
        $target_dir = "uploads/cookbook/";
        
        // Folder မရှိရင် ဆောက်မယ်
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_ext = pathinfo($_FILES['recipe_image']['name'], PATHINFO_EXTENSION);
        // နာမည်တူမရှိအောင် Unique Name ပေးမယ် (ဥပမာ- 1712345678.jpg)
        $new_filename = time() . '.' . $file_ext;
        $target_file = $target_dir . $new_filename;

        // ပုံဟုတ်မဟုတ် စစ်မယ်
        $check = getimagesize($_FILES['recipe_image']['tmp_name']);
        if($check !== false) {
            if (move_uploaded_file($_FILES['recipe_image']['tmp_name'], $target_file)) {
                $image_name = $new_filename;
            } else {
                $error = "Sorry, there was an error uploading your image.";
            }
        } else {
            $error = "File is not an image.";
        }
    }

    if (empty($error)) {
        try {
            // image_url column ပါ ထည့်သွင်းမယ်
            $stmt = $pdo->prepare("INSERT INTO community_cookbook (user_id, recipe_title, recipe_content, image_url) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user_id, $title, $content, $image_name]);
            $success = "Your recipe was added to the Community Cookbook!";
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
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
            
            <?php if($error): ?>
                <div class="bg-red-50 text-red-600 p-5 rounded-2xl mb-8 border border-red-100 font-bold">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-8">
                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Recipe Title</label>
                    <input type="text" name="recipe_title" required placeholder="e.g. Grandma's Secret Curry" 
                           class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-bold text-slate-700">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Cover Image (Optional)</label>
                    <div class="relative group">
                        <input type="file" name="recipe_image" accept="image/*" 
                               class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-2 border-dashed border-stone-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-emerald-800 file:text-white hover:border-emerald-500 transition-all cursor-pointer text-stone-400 font-medium">
                    </div>
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