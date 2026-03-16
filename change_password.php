<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        // 1. Fetch current hashed password
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        // 2. Verify current password
        if (password_verify($current_password, $user['password'])) {
            // 3. Check if new passwords match
            if ($new_password === $confirm_password) {
                // 4. Validate strength (e.g., min 8 chars)
                if (strlen($new_password) >= 8) {
                    $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                    $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $update->execute([$new_hashed, $user_id]);
                    $success = "Password updated successfully.";
                } else {
                    $error = "New password must be at least 8 characters long.";
                }
            } else {
                $error = "New passwords do not match.";
            }
        } else {
            $error = "Current password is incorrect.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<div class="bg-stone-50 min-h-screen pt-32 pb-24">
    <div class="max-w-2xl mx-auto px-6">
        
        <div class="mb-12">
            <a href="edit_profile.php" class="text-[10px] font-black uppercase tracking-widest text-stone-400 hover:text-emerald-600 transition-colors flex items-center gap-2 mb-6">
                ← Back to Settings
            </a>
            <h1 class="text-4xl font-serif text-stone-900 italic">Security Upgrade</h1>
            <p class="text-stone-400 mt-2 font-light italic">Ensure your account remains secure with a strong password.</p>
        </div>

        <div class="bg-white p-10 md:p-16 rounded-[3rem] border border-stone-100 shadow-sm">
            
            <?php if($success): ?>
                <div class="mb-8 p-5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-2xl border border-emerald-100 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if($error): ?>
                <div class="mb-8 p-5 bg-red-50 text-red-700 text-xs font-bold rounded-2xl border border-red-100 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-8">
                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-3 tracking-widest">Current Password</label>
                    <input type="password" name="current_password" required 
                           class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none ring-1 ring-stone-200 focus:ring-2 focus:ring-emerald-500 transition-all outline-none">
                </div>

                <hr class="border-stone-50">

                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-3 tracking-widest">New Password</label>
                    <input type="password" name="new_password" required 
                           class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none ring-1 ring-stone-200 focus:ring-2 focus:ring-emerald-500 transition-all outline-none">
                    <p class="text-[9px] text-stone-400 mt-3 italic">Minimum 8 characters with at least one number.</p>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-3 tracking-widest">Confirm New Password</label>
                    <input type="password" name="confirm_password" required 
                           class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none ring-1 ring-stone-200 focus:ring-2 focus:ring-emerald-500 transition-all outline-none">
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full px-12 py-5 bg-emerald-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-emerald-800 transition-all shadow-xl shadow-emerald-900/10">
                        Confirm Security Change
                    </button>
                </div>
            </form>

        </div>

        <div class="mt-10 p-8 bg-amber-50 rounded-[2rem] border border-amber-100 flex gap-4">
            <span class="text-xl">💡</span>
            <p class="text-xs text-amber-800 leading-relaxed font-medium">
                <strong class="block mb-1">Safety Tip:</strong> 
                Avoid using passwords you use on other sites. A unique password for FoodFusion keeps your community contributions safe.
            </p>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>