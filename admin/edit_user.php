<?php
require_once '../config/db.php';
session_start();

// Admin မဟုတ်လျှင် ပေးမဝင်ရန် တားဆီးခြင်း
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$error = '';
$success = '';

// 1. URL ကနေ ID ရယူခြင်း (သင့် table က id သို့မဟုတ် user_id ဖြစ်နိုင်သည်)
if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}
$u_id = $_GET['id'];

// 2. လက်ရှိ User အချက်အလက်ကို ဆွဲထုတ်ခြင်း
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$u_id]);
    $user = $stmt->fetch();

    if (!$user) {
        header("Location: manage_users.php?error=User not found");
        exit();
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// 3. Update Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_role = $_POST['role'];
    
    try {
        $update_stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
        $update_stmt->execute([$new_role, $u_id]);
        
        $success = "User role updated successfully!";
        // ၁ စက္ကန့်အကြာတွင် မူလစာမျက်နှာသို့ ပြန်ပို့မည်
        header("Refresh: 1; URL=manage_users.php");
    } catch (PDOException $e) {
        $error = "Update failed: " . $e->getMessage();
    }
}

include '../includes/header.php';
?>

<div class="flex min-h-screen bg-slate-50 items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-stone-100 overflow-hidden">
        <div class="bg-emerald-800 p-8 text-white text-center">
            <div class="w-20 h-20 bg-emerald-700 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-emerald-600">
                <span class="text-2xl font-black italic">
                    <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
                </span>
            </div>
            <h2 class="text-xl font-bold"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h2>
            <p class="text-emerald-200 text-sm opacity-80"><?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <div class="p-8">
            <?php if($success): ?>
                <div class="bg-emerald-50 text-emerald-700 p-4 rounded-2xl mb-6 font-bold text-sm text-center border border-emerald-100">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if($error): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 font-bold text-sm text-center border border-red-100">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Change Access Level</label>
                    <select name="role" class="w-full px-5 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-bold text-slate-700 transition-all">
                        <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>Community Member (User)</option>
                        <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>System Administrator (Admin)</option>
                    </select>
                </div>

                <div class="flex flex-col gap-3 pt-4">
                    <button type="submit" class="w-full bg-emerald-800 text-white py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-900/20 transition-all active:scale-[0.98]">
                        Save Changes
                    </button>
                    <a href="manage_users.php" class="w-full text-center py-4 text-stone-400 font-bold hover:text-stone-600 transition-colors">
                        Cancel & Go Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>