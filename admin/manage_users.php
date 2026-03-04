<?php
require_once '../config/db.php';
session_start();

// Admin Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// User ဖျက်သည့် Logic
if (isset($_GET['delete'])) {
    $u_id = $_GET['delete'];
    
    // မိမိကိုယ်တိုင် ပြန်မဖျက်မိစေရန် စစ်ဆေးခြင်း (Optional but recommended)
    if ($u_id == $_SESSION['user_id']) {
        header("Location: manage_users.php?error=You cannot delete yourself!");
        exit();
    }

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$u_id]);
    header("Location: manage_users.php?msg=User deleted successfully");
    exit();
}

// User အားလုံးကို ဆွဲထုတ်ခြင်း
$users = $pdo->query("SELECT id, first_name, last_name, email, role, created_at FROM users ORDER BY created_at DESC")->fetchAll();

include '../includes/header.php';
?>

<div class="flex min-h-screen bg-slate-50">
    <aside class="w-64 bg-emerald-900 text-white hidden lg:flex flex-col shrink-0">
        <div class="p-6 text-2xl font-black tracking-tighter">FOOD<span class="text-emerald-400">FUSION</span></div>
        <nav class="flex-grow mt-4">
            <a href="index.php" class="block px-6 py-4 text-emerald-100 hover:bg-emerald-800 transition font-medium">Dashboard Overview</a>
            <a href="manage_recipes.php" class="block px-6 py-4 text-emerald-100 hover:bg-emerald-800 transition font-medium">Manage Recipes</a>
            <a href="manage_users.php" class="block px-6 py-4 bg-emerald-800 border-l-4 border-emerald-400 font-bold">User Management</a>
            <a href="manage_community.php" class="block px-6 py-4 text-emerald-100 hover:bg-emerald-800 transition font-medium">Cookbook Management</a>
            <a href="manage_messages.php" class="block px-6 py-4 text-emerald-100 hover:bg-emerald-800 transition font-medium">Contact Messages</a>
        </nav>
    </aside>

    <main class="flex-grow p-8">
        <header class="mb-10">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">User Management</h1>
            <p class="text-slate-500 mt-1">Review and manage community members and their access levels.</p>
        </header>

        <?php if(isset($_GET['msg'])): ?>
            <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl mb-6 font-bold text-sm border border-emerald-200">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 font-bold text-sm border border-red-200">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-3xl shadow-sm border border-stone-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-stone-50 text-stone-400 text-[10px] font-black uppercase tracking-[0.2em]">
                            <th class="px-8 py-5">Full Name</th>
                            <th class="px-8 py-5">Email Address</th>
                            <th class="px-8 py-5">Access Role</th>
                            <th class="px-8 py-5">Joined Date</th>
                            <th class="px-8 py-5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-50">
                        <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5 font-bold text-slate-700">
                                <?php echo htmlspecialchars($u['first_name'] . ' ' . $u['last_name']); ?>
                            </td>
                            <td class="px-8 py-5 text-slate-500 text-sm">
                                <?php echo htmlspecialchars($u['email']); ?>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider 
                                    <?php echo $u['role'] === 'admin' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700'; ?>">
                                    <?php echo $u['role']; ?>
                                </span>
                            </td>
                            <td class="px-8 py-5 text-stone-400 text-xs font-medium">
                                <?php echo date('M d, Y', strtotime($u['created_at'])); ?>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="edit_user.php?id=<?php echo $u['id']; ?>" class="text-emerald-600 hover:text-emerald-800 font-bold text-sm transition">
                                        Edit Role
                                    </a>
                                    <span class="text-stone-200">|</span>
                                    <a href="manage_users.php?delete=<?php echo $u['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to remove this user?')"
                                       class="text-red-400 hover:text-red-600 font-bold text-sm transition">
                                        Remove
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if(empty($users)): ?>
                <div class="p-20 text-center text-stone-400 font-medium">
                    No registered users found.
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>