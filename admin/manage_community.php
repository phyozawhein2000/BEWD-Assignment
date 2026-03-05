<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';
include '../includes/header.php';

// Admin Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$success = '';
$error = '';

// Delete Logic
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM community_cookbook WHERE submission_id = ?");
        $stmt->execute([$delete_id]);
        $success = "Submission removed successfully.";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Data Fetching
try {
    $stmt = $pdo->query("SELECT c.*, u.first_name, u.last_name, u.email 
                        FROM community_cookbook c 
                        JOIN users u ON c.user_id = u.id 
                        ORDER BY c.submitted_at DESC");
    $submissions = $stmt->fetchAll();
} catch (PDOException $e) {
    $submissions = [];
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
                <span class="w-1.5 h-1.5 bg-emerald-700 rounded-full group-hover:bg-emerald-400"></span>
                Dashboard Overview
            </a>
            <a href="manage_recipes.php" class="flex items-center gap-3 px-6 py-4 text-emerald-100/70 hover:bg-emerald-800/50 hover:text-white rounded-2xl transition-all group">
                <span class="w-1.5 h-1.5 bg-emerald-700 rounded-full group-hover:bg-emerald-400"></span>
                Manage Recipes
            </a>
            <a href="manage_users.php" class="flex items-center gap-3 px-6 py-4 text-emerald-100/70 hover:bg-emerald-800/50 hover:text-white rounded-2xl transition-all group">
                <span class="w-1.5 h-1.5 bg-emerald-700 rounded-full group-hover:bg-emerald-400"></span>
                User Management
            </a>
            <a href="manage_subscribers.php" class="flex items-center gap-3 px-6 py-4 bg-emerald-500/10 text-emerald-400 rounded-2xl border border-emerald-500/20 font-bold shadow-lg shadow-emerald-900/50">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                Newsletter Subs
            </a>
            <a href="manage_community.php" class="flex items-center gap-3 px-6 py-4 text-emerald-100/70 hover:bg-emerald-800/50 hover:text-white rounded-2xl transition-all group">
                <span class="w-1.5 h-1.5 bg-emerald-700 rounded-full group-hover:bg-emerald-400"></span>
                Cookbook Management
            </a>
        </nav>

        <div class="p-8 border-t border-emerald-800/50">
            <a href="../auth/logout.php" class="text-xs font-bold text-emerald-100/40 hover:text-red-400 transition-colors uppercase tracking-widest">Sign Out</a>
        </div>
    </aside>

    <main class="flex-grow p-8">
        <header class="mb-10 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Cookbook Management</h1>
                <p class="text-slate-500 mt-1">Monitor and moderate community-submitted recipes.</p>
            </div>
            <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-stone-100 text-right">
                <p class="text-[10px] font-black uppercase text-stone-400 tracking-widest">Total Posts</p>
                <p class="text-xl font-black text-emerald-600"><?php echo count($submissions); ?></p>
            </div>
        </header>

        <?php if($success): ?>
            <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl mb-6 font-bold text-sm border border-emerald-200">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 font-bold text-sm border border-red-200">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-3xl shadow-sm border border-stone-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-stone-50 text-stone-400 text-[10px] font-black uppercase tracking-[0.2em]">
                            <th class="px-8 py-5">Author</th>
                            <th class="px-8 py-5">Recipe Info</th>
                            <th class="px-8 py-5">Submitted At</th>
                            <th class="px-8 py-5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-50">
                        <?php foreach ($submissions as $row): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="font-bold text-slate-700">
                                    <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?>
                                </div>
                                <div class="text-[11px] text-stone-400 font-medium italic">
                                    <?php echo htmlspecialchars($row['email']); ?>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="font-bold text-emerald-700 text-sm mb-1">
                                    <?php echo htmlspecialchars($row['recipe_title']); ?>
                                </div>
                                <div class="text-[11px] text-slate-500 truncate max-w-xs font-medium">
                                    <?php echo substr(htmlspecialchars($row['recipe_content']), 0, 60); ?>...
                                </div>
                            </td>
                            <td class="px-8 py-6 text-stone-400 text-xs font-medium uppercase">
                                <?php echo date('M d, Y', strtotime($row['submitted_at'])); ?>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end space-x-4">
                                    <a href="view_submission.php?id=<?php echo $row['submission_id']; ?>" 
                                       class="text-emerald-600 hover:text-emerald-800 font-extrabold text-[11px] uppercase tracking-tighter transition">
                                        View
                                    </a>
                                    <span class="text-stone-200">|</span>
                                    <a href="manage_community.php?delete_id=<?php echo $row['submission_id']; ?>" 
                                       onclick="return confirm('Remove this recipe from the cookbook?')"
                                       class="text-red-400 hover:text-red-600 font-extrabold text-[11px] uppercase tracking-tighter transition">
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if(empty($submissions)): ?>
                <div class="p-20 text-center">
                    <div class="bg-stone-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <p class="text-stone-400 font-bold italic">No community recipes found.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>