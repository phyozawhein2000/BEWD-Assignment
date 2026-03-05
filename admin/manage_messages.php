<?php
require_once '../config/db.php';
session_start();

// Admin Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// 1. Delete Message Logic
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE message_id = ?");
    $stmt->execute([$id]);
    header("Location: manage_messages.php?msg=Message Deleted");
    exit();
}

// 2. Mark as Read Logic (Optional)
if (isset($_GET['read'])) {
    $id = $_GET['read'];
    $stmt = $pdo->prepare("UPDATE contact_messages SET status = 'read' WHERE message_id = ?");
    $stmt->execute([$id]);
    header("Location: manage_messages.php");
    exit();
}

// 3. Fetch All Messages
$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();

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
        <header class="mb-10">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Inbound Messages</h1>
            <p class="text-slate-500 mt-1">Manage user inquiries and feedback from the contact form.</p>
        </header>

        <?php if(isset($_GET['msg'])): ?>
            <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl mb-6 font-bold text-sm">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 gap-6">
            <?php foreach ($messages as $m): ?>
                <div class="bg-white p-6 rounded-3xl shadow-sm border <?php echo $m['status'] === 'unread' ? 'border-emerald-200 bg-emerald-50/30' : 'border-stone-100'; ?> transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-stone-100 flex items-center justify-center font-black text-stone-400 uppercase">
                                <?php echo substr($m['name'], 0, 1); ?>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800"><?php echo htmlspecialchars($m['name']); ?></h3>
                                <p class="text-xs text-stone-400 font-medium"><?php echo htmlspecialchars($m['email']); ?> • <?php echo date('M d, Y h:i A', strtotime($m['created_at'])); ?></p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <?php if($m['status'] === 'unread'): ?>
                                <a href="manage_messages.php?read=<?php echo $m['message_id']; ?>" class="px-3 py-1 bg-emerald-600 text-white text-[10px] font-black uppercase rounded-lg hover:bg-emerald-700 transition">Mark as Read</a>
                            <?php endif; ?>
                            <a href="manage_messages.php?delete=<?php echo $m['message_id']; ?>" 
                               onclick="return confirm('Delete this message?')"
                               class="p-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="pl-16">
                        <p class="text-xs font-black text-emerald-700 uppercase tracking-widest mb-1"><?php echo htmlspecialchars($m['subject'] ?? 'No Subject'); ?></p>
                        <p class="text-slate-600 leading-relaxed text-sm italic">
                            "<?php echo nl2br(htmlspecialchars($m['message'])); ?>"
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if(empty($messages)): ?>
                <div class="p-20 text-center bg-white rounded-3xl border border-stone-100">
                    <p class="text-stone-400 font-medium italic">Your inbox is empty. No messages yet!</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>