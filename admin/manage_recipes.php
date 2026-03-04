<?php
require_once '../config/db.php';
session_start();

// Admin Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Delete Logic (Column name 'recipe_id' ကို အသုံးပြုထားသည်)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM recipes WHERE recipe_id = ?");
    $stmt->execute([$id]);
    header("Location: manage_recipes.php?msg=Deleted Successfully");
    exit();
}

// Fetch All Recipes (Column name 'recipe_id' ကို အသုံးပြုထားသည်)
$recipes = $pdo->query("SELECT * FROM recipes ORDER BY recipe_id DESC")->fetchAll();

include '../includes/header.php';
?>

<div class="flex min-h-screen bg-slate-50">
    <aside class="w-64 bg-emerald-900 text-white hidden lg:flex flex-col shrink-0">
        <div class="p-6 text-2xl font-black tracking-tighter">FOOD<span class="text-emerald-400">FUSION</span></div>
        <nav class="flex-grow mt-4">
            <a href="index.php" class="block px-6 py-4 text-emerald-100 hover:bg-emerald-800 transition font-medium">Dashboard Overview</a>
            <a href="manage_recipes.php" class="block px-6 py-4 bg-emerald-800 border-l-4 border-emerald-400 font-bold">Manage Recipes</a>
            <a href="manage_users.php" class="block px-6 py-4 text-emerald-100 hover:bg-emerald-800 transition font-medium">User Management</a>
            <a href="manage_community.php" class="block px-6 py-4 text-emerald-100 hover:bg-emerald-800 transition font-medium">Cookbook Management</a>
            <a href="manage_messages.php" class="block px-6 py-4 text-emerald-100 hover:bg-emerald-800 transition font-medium">Contact Messages</a>
        </nav>
    </aside>

    <main class="flex-grow p-8">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Manage Recipes</h1>
                <p class="text-slate-500 mt-1">Add, edit, or remove recipes from the platform.</p>
            </div>
            <a href="add_recipe.php" class="bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Add New Recipe
            </a>
        </div>

        <?php if(isset($_GET['msg'])): ?>
            <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl mb-6 font-bold text-sm">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-3xl shadow-sm border border-stone-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-stone-50 text-stone-400 text-[10px] font-black uppercase tracking-[0.2em]">
                        <th class="px-8 py-5">Image & Title</th>
                        <th class="px-8 py-5">Cuisine Type</th>
                        <th class="px-8 py-5">Difficulty</th>
                        <th class="px-8 py-5">Dietary Preference</th>
                        <th class="px-8 py-5">Description</th>
                        <th class="px-8 py-5">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    <?php foreach ($recipes as $r): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center space-x-4">
                                <img src="../<?php echo !empty($r['image_url']) ? $r['image_url'] : 'https://via.placeholder.com/150'; ?>" class="w-14 h-14 rounded-xl object-cover shadow-sm border border-stone-100">
                                <div>
                                    <p class="font-bold text-slate-800"><?php echo htmlspecialchars($r['title']); ?></p>
                                    <p class="text-xs text-stone-400 italic">ID: #<?php echo $r['recipe_id']; ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 bg-stone-100 text-stone-600 rounded-lg text-xs font-bold uppercase tracking-wider">
                                <?php echo htmlspecialchars($r['cuisine_type'] ?? 'General'); ?>
                            </span>
                        </td>
                        <td class="px-8 py-5 text-sm font-semibold text-slate-600">
                            <?php echo htmlspecialchars($r['difficulty'] ?? 'Medium'); ?>
                        </td>
                        <td class="px-8 py-5 text-sm text-stone-500">
                            <?php echo htmlspecialchars($r['dietary_preference'] ?? 'N/A'); ?>
                        </td>
                        <td class="px-8 py-5 text-sm font-medium text-stone-600">
                            <?php echo  htmlspecialchars($r['description'] ? substr($r['description'], 0, 50) : 'No description'); ?>   
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center space-x-4">
                                <a href="edit_recipe.php?id=<?php echo $r['recipe_id']; ?>" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                </a>
                                <a href="manage_recipes.php?delete=<?php echo $r['recipe_id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this recipe?')"
                                   class="p-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>