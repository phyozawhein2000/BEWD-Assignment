<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
try {
    $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $recipeCount = $pdo->query("SELECT COUNT(*) FROM recipes")->fetchColumn();

    // လက်ရှိ User စာရင်းကို ဆွဲထုတ်ခြင်း
    $stmt = $pdo->query("SELECT id, first_name, last_name, email, role, created_at FROM users ORDER BY created_at DESC LIMIT 10");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
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
            <a href="manage_subscribers.php" class="flex items-center gap-3 px-6 py-4 text-emerald-100/70 hover:bg-emerald-800/50 hover:text-white rounded-2xl transition-all group">
                Subscribe Management
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
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Admin Dashboard</h1>
                <p class="text-slate-500 mt-1">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?>.</p>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-slate-500 text-sm font-medium uppercase">Total Members</p>
                <p class="text-4xl font-black text-emerald-600 mt-2"><?php echo $userCount; ?></p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-slate-500 text-sm font-medium uppercase">Total Recipes</p>
                <p class="text-4xl font-black text-slate-800 mt-2"><?php echo $recipeCount; ?></p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-slate-500 text-sm font-medium uppercase">Server Status</p>
                <p class="text-sm font-bold text-emerald-500 mt-4 flex items-center">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span> Online
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Recently Joined Users</h3>
                <a href="manage_users.php" class="text-emerald-600 text-xs font-bold hover:underline">View All Users</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[11px] font-black uppercase tracking-widest">
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Joined Date</th>
                            <th class="px-6 py-4">Action</th> </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-bold text-slate-700"><?php echo htmlspecialchars($u['first_name'] . ' ' . $u['last_name']); ?></td>
                            <td class="px-6 py-4 text-slate-500"><?php echo htmlspecialchars($u['email']); ?></td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase <?php echo $u['role'] === 'admin' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700'; ?>">
                                    <?php echo $u['role']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-stone-400 font-medium"><?php echo date('M d, Y', strtotime($u['created_at'])); ?></td>
                            <td class="px-6 py-4">
                                <a href="edit_user.php?id=<?php echo $u['id']; ?>" class="text-emerald-600 font-bold hover:underline">Edit</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
