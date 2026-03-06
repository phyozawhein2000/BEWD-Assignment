<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';

// Admin Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_community.php");
    exit();
}

$submission_id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT c.*, u.first_name, u.last_name, u.email 
                          FROM community_cookbook c 
                          JOIN users u ON c.user_id = u.id 
                          WHERE c.submission_id = ?");
    $stmt->execute([$submission_id]);
    $recipe = $stmt->fetch();

    if (!$recipe) {
        header("Location: manage_community.php?error=Recipe not found.");
        exit();
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="flex min-h-screen bg-[#f8fafc]">
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
            <a href="manage_subscribers.php" class="flex items-center gap-3 px-6 py-4 text-emerald-100/70 hover:bg-emerald-800/50 hover:text-white rounded-2xl transition-all group">
                <span class="w-1.5 h-1.5 bg-emerald-700 rounded-full group-hover:bg-emerald-400"></span>
                Subscribe Management
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

    <main class="flex-grow p-6 lg:p-10">
        <div class="flex justify-between items-center mb-10">
            <a href="manage_community.php" class="group flex items-center gap-2 text-slate-500 hover:text-slate-800 transition-all font-bold text-sm">
                <div class="p-2 bg-white rounded-lg shadow-sm group-hover:shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                Return to List
            </a>
            
            <div class="flex gap-3">
                <button onclick="window.print()" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition shadow-sm">Print</button>
                <a href="manage_community.php?delete_id=<?php echo $recipe['submission_id']; ?>" 
                   onclick="return confirm('Permanently delete this submission?')"
                   class="px-5 py-2.5 bg-red-50 text-red-600 border border-red-100 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-red-600 hover:text-white transition shadow-sm">Delete</a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 space-y-8">
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-8 lg:p-12 border-b border-slate-50">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600">Recipe Review Mode</span>
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight">
                            <?php echo htmlspecialchars($recipe['recipe_title']); ?>
                        </h1>
                    </div>
                    
                    <div class="p-8 lg:p-12">
                        <h3 class="text-xs font-black uppercase text-slate-400 tracking-widest mb-6">Recipe Content</h3>
                        <div class="bg-slate-50 p-8 rounded-3xl text-slate-700 leading-relaxed text-lg font-medium whitespace-pre-line border border-slate-100 italic shadow-inner">
                            <?php echo htmlspecialchars($recipe['recipe_content']); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <h3 class="text-xs font-black uppercase text-slate-400 tracking-widest mb-6">Author Profile</h3>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center text-white text-2xl font-black shadow-lg shadow-emerald-200">
                            <?php echo strtoupper(substr($recipe['first_name'], 0, 1)); ?>
                        </div>
                        <div>
                            <p class="font-black text-slate-900 text-lg"><?php echo htmlspecialchars($recipe['first_name'] . ' ' . $recipe['last_name']); ?></p>
                            <p class="text-sm text-emerald-600 font-bold"><?php echo htmlspecialchars($recipe['email']); ?></p>
                        </div>
                    </div>
                    <div class="space-y-3 pt-6 border-t border-slate-50">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400 font-medium">Submission ID</span>
                            <span class="text-slate-900 font-bold">#<?php echo $recipe['submission_id']; ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400 font-medium">Date Sent</span>
                            <span class="text-slate-900 font-bold"><?php echo date('M d, Y', strtotime($recipe['submitted_at'])); ?></span>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 p-8 rounded-[2rem] shadow-xl text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-[10px] font-black uppercase text-slate-500 tracking-widest mb-4">Moderation</h3>
                        <p class="text-sm text-slate-300 mb-6 leading-relaxed">Review the content for community guidelines before keeping it active.</p>
                        <div class="flex flex-col gap-2">
                            <button class="w-full py-3 bg-emerald-500 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-400 transition">Mark as Featured</button>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-3xl"></div>
                </div>
            </div>
        </div>
    </main>
</div>