<?php
require_once '../config/db.php';
session_start();

// Admin Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Subscriber ဖျက်သည့် Logic
if (isset($_GET['delete'])) {
    $s_id = $_GET['delete'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM newsletter_subscribers WHERE id = ?");
        $stmt->execute([$s_id]);
        header("Location: manage_subscribers.php?msg=Subscriber removed successfully");
    } catch (PDOException $e) {
        header("Location: manage_subscribers.php?error=Error removing subscriber.");
    }
    exit();
}

// Subscriber အားလုံးကို ဆွဲထုတ်ခြင်း
$subscribers = $pdo->query("SELECT id, email, subscribed_at FROM subscribers ORDER BY subscribed_at DESC")->fetchAll();

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

    <main class="flex-grow p-10 lg:p-16">
        <header class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-800 tracking-tight mb-2">Newsletter Audience</h1>
                <p class="text-slate-500 font-medium">Manage your subscribers and export email lists for marketing.</p>
            </div>
            <div class="flex gap-4">
                <button onclick="window.print()" class="bg-white px-6 py-3 rounded-2xl border border-stone-100 shadow-sm text-[10px] font-black uppercase tracking-widest text-stone-600 hover:bg-stone-50 transition-all">
                    Print List
                </button>
                <div class="bg-white px-6 py-3 rounded-2xl border border-stone-100 shadow-sm">
                    <span class="text-stone-400 text-[10px] font-black uppercase tracking-widest block mb-1">Subscribers</span>
                    <span class="text-2xl font-black text-emerald-600"><?php echo count($subscribers); ?></span>
                </div>
            </div>
        </header>

        <?php if(isset($_GET['msg'])): ?>
            <div class="bg-emerald-50 text-emerald-700 p-5 rounded-2xl mb-8 font-bold text-sm border border-emerald-100 flex items-center gap-3 animate-slide-up">
                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-stone-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-stone-50/50 text-stone-400 text-[10px] font-black uppercase tracking-[0.2em]">
                            <th class="px-10 py-6">Email Address</th>
                            <th class="px-10 py-6">Subscription Date</th>
                            <th class="px-10 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-50">
                        <?php foreach ($subscribers as $s): ?>
                        <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 font-black text-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span class="font-bold text-slate-800 text-base"><?php echo htmlspecialchars($s['email']); ?></span>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <span class="text-stone-400 text-xs font-bold italic">
                                    <?php echo date('M d, Y — h:i A', strtotime($s['subscribed_at'])); ?>
                                </span>
                            </td>
                            <td class="px-10 py-6">
                                <div class="flex items-center justify-end">
                                    <a href="manage_subscribers.php?delete=<?php echo $s['id']; ?>" 
                                       onclick="return confirm('Remove this email from your mailing list?')"
                                       class="text-[10px] font-black uppercase tracking-widest text-red-300 hover:text-red-600 transition-colors">
                                        Remove Subscriber
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if(empty($subscribers)): ?>
                <div class="p-20 text-center">
                    <p class="text-stone-400 italic font-medium">No subscribers found in your list.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<style>
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-up { animation: slide-up 0.5s ease forwards; }
    @media print {
        aside, button { display: none !important; }
        main { padding: 0 !important; }
    }
</style>