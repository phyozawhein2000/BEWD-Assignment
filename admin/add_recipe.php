<?php
require_once '../config/db.php';
session_start();

// Admin Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $cuisine_type = $_POST['cuisine_type']; // Category 
    $dietary_preference = $_POST['dietary_preference'];
    $difficulty = $_POST['difficulty'];
    
    // Image Upload Logic
    $target_dir = "../uploads/recipes/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_name = time() . '_' . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;
    $db_image_path = "uploads/recipes/" . $file_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        try {
            
            $stmt = $pdo->prepare("INSERT INTO recipes (title, description, cuisine_type, dietary_preference, difficulty, image_url,user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $cuisine_type, $dietary_preference, $difficulty, $db_image_path, $_SESSION['user_id']]);
            $success = "Recipe added successfully!";
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    } else {
        $error = "Failed to upload image.";
    }
}

include '../includes/header.php';
?>

<div class="flex min-h-screen bg-slate-50">
    <aside class="w-72 bg-emerald-900 text-white hidden lg:flex flex-col shrink-0 shadow-2xl">
        <div class="p-8">
            <div class="text-2xl font-black tracking-tighter italic">FOOD<span class="text-emerald-400 font-normal">FUSION</span></div>
            <p class="text-[10px] text-emerald-400/50 uppercase tracking-[0.3em] font-bold mt-1">Admin Control Panel</p>
        </div>
        
        <nav class="flex-grow px-4 space-y-2">
            <a href="index.php" class="flex items-center gap-3 px-6 py-4 text-emerald-100/70 hover:bg-emerald-800/50 hover:text-white rounded-2xl transition-all group">
                <!-- <span class="w-1.5 h-1.5 bg-emerald-700 rounded-full group-hover:bg-emerald-400"></span> -->
                Dashboard Overview
            </a>
            <a href="manage_recipes.php" class="flex items-center gap-3 px-6 py-4 text-emerald-100/70 hover:bg-emerald-800/50 hover:text-white rounded-2xl transition-all group">
                Manage Recipes
            </a>
            <a href="manage_users.php" class="flex items-center gap-3 px-6 py-4 text-emerald-100/70 hover:bg-emerald-800/50 hover:text-white rounded-2xl transition-all group">
                User Management
            </a>
            <a href="manage_subscribers.php" class="flex items-center gap-3 px-6 py-4 bg-emerald-500/10 text-emerald-400 rounded-2xl border border-emerald-500/20 font-bold shadow-lg shadow-emerald-900/50">
                Newsletter Subs
            </a>
            <a href="manage_community.php" class="flex items-center gap-3 px-6 py-4 text-emerald-100/70 hover:bg-emerald-800/50 hover:text-white rounded-2xl transition-all group">
                Cookbook Management
            </a>
        </nav>

        <div class="p-8 border-t border-emerald-800/50">
            <a href="../auth/logout.php" class="text-xs font-bold text-emerald-100/40 hover:text-red-400 transition-colors uppercase tracking-widest">Sign Out</a>
        </div>
    </aside>

    <main class="flex-grow p-8">
        <div class="max-w-4xl mx-auto">
            <header class="mb-10">
                <a href="manage_recipes.php" class="text-emerald-600 font-bold text-sm flex items-center gap-2 mb-4">&larr; Back to List</a>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Add New Recipe</h1>
            </header>

            <form action="add_recipe.php" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl shadow-sm border border-stone-100 space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black uppercase text-stone-400 mb-2 tracking-widest">Recipe Title</label>
                        <input type="text" name="title" required class="w-full px-5 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-stone-400 mb-2 tracking-widest">Cuisine Type</label>
                        <input type="text" name="cuisine_type" placeholder="e.g. Italian, Myanmar" required class="w-full px-5 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-stone-400 mb-2 tracking-widest">Dietary Preference</label>
                        <select name="dietary_preference" class="w-full px-5 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-bold text-stone-600">
                            <option value="Non-Vegetarian">Non-Vegetarian</option>
                            <option value="Vegetarian">Vegetarian</option>
                            <option value="Vegan">Vegan</option>
                            <option value="Gluten-Free">Gluten-Free</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-stone-400 mb-2 tracking-widest">Difficulty</label>
                        <select name="difficulty" class="w-full px-5 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-bold text-stone-600">
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-stone-400 mb-2 tracking-widest">Recipe Image</label>
                        <input type="file" name="image" required class="w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase text-stone-400 mb-2 tracking-widest">Description & Instructions</label>
                    <textarea name="description" rows="6" required class="w-full px-5 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-medium"></textarea>
                </div>

                <button type="submit" class="w-full bg-emerald-800 text-white py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-700 shadow-xl shadow-emerald-900/20 transition-all active:scale-[0.98]">
                    Publish Recipe
                </button>
            </form>
        </div>
    </main>
</div>