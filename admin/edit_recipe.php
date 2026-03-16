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

// 1. URL မှ Recipe ID ကို ရယူခြင်း
if (!isset($_GET['id'])) {
    header("Location: manage_recipes.php");
    exit();
}
$recipe_id = $_GET['id'];

// 2. လက်ရှိ Recipe အချက်အလက်များကို ဆွဲထုတ်ခြင်း
try {
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE recipe_id = ?");
    $stmt->execute([$recipe_id]);
    $recipe = $stmt->fetch();

    if (!$recipe) {
        die("Recipe not found!");
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// 3. Update Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $cuisine_type = $_POST['cuisine_type'];
    $dietary_preference = $_POST['dietary_preference'];
    $difficulty = $_POST['difficulty'];
    $image_url = $recipe['image_url']; // Default 

    // Image Upload Logic
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "../uploads/recipes/";
        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = "uploads/recipes/" . $file_name;
        }
    }

    try {
        $sql = "UPDATE recipes SET title=?, description=?, cuisine_type=?, dietary_preference=?, difficulty=?, image_url=? WHERE recipe_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $description, $cuisine_type, $dietary_preference, $difficulty, $image_url, $recipe_id]);
        
        $success = "Recipe updated successfully!";
        // Update 
        header("Refresh: 1; URL=manage_recipes.php");
    } catch (PDOException $e) {
        $error = "Database Error: " . $e->getMessage();
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
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Edit Recipe</h1>
                <p class="text-stone-500 italic">Editing: <?php echo htmlspecialchars($recipe['title']); ?></p>
            </header>

            <?php if($success): ?>
                <div class="bg-emerald-100 text-emerald-700 p-4 rounded-2xl mb-6 font-bold text-center">
                    <?php echo $success; ?> - Redirecting...
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl shadow-sm border border-stone-100 space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black uppercase text-stone-400 mb-2">Recipe Title</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required 
                               class="w-full px-5 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-stone-400 mb-2">Cuisine Type</label>
                        <input type="text" name="cuisine_type" value="<?php echo htmlspecialchars($recipe['cuisine_type']); ?>" required 
                               class="w-full px-5 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-stone-400 mb-2">Dietary Preference</label>
                        <select name="dietary_preference" class="w-full px-5 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-bold text-stone-600">
                            <option value="Non-Vegetarian" <?php if($recipe['dietary_preference'] == 'Non-Vegetarian') echo 'selected'; ?>>Non-Vegetarian</option>
                            <option value="Vegetarian" <?php if($recipe['dietary_preference'] == 'Vegetarian') echo 'selected'; ?>>Vegetarian</option>
                            <option value="Vegan" <?php if($recipe['dietary_preference'] == 'Vegan') echo 'selected'; ?>>Vegan</option>
                            <option value="Gluten-Free" <?php if($recipe['dietary_preference'] == 'Gluten-Free') echo 'selected'; ?>>Gluten-Free</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-stone-400 mb-2">Difficulty</label>
                        <select name="difficulty" class="w-full px-5 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-bold text-stone-600">
                            <option value="Easy" <?php if($recipe['difficulty'] == 'Easy') echo 'selected'; ?>>Easy</option>
                            <option value="Medium" <?php if($recipe['difficulty'] == 'Medium') echo 'selected'; ?>>Medium</option>
                            <option value="Hard" <?php if($recipe['difficulty'] == 'Hard') echo 'selected'; ?>>Hard</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-stone-400 mb-2">Change Image (Leave blank to keep current)</label>
                        <input type="file" name="image" class="w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-emerald-50 file:text-emerald-700">
                        <div class="mt-2 text-[10px] text-stone-400">Current: <?php echo $recipe['image_url']; ?></div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase text-stone-400 mb-2">Description & Instructions</label>
                    <textarea name="description" rows="6" required class="w-full px-5 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-medium"><?php echo htmlspecialchars($recipe['description']); ?></textarea>
                </div>

                <button type="submit" class="w-full bg-emerald-800 text-white py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-700 shadow-xl transition-all">
                    Update Recipe
                </button>
            </form>
        </div>
    </main>
</div>
