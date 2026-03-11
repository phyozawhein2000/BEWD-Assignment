<?php 
require_once '../config/db.php';
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // User အချက်အလက်နှင့် Lockout status ကို စစ်ဆေးခြင်း
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $now = new DateTime();
        $lockout_until = $user['lockout_until'] ? new DateTime($user['lockout_until']) : null;

        // Task 2: ၃ မိနစ် lockout စစ်ဆေးခြင်း
        if ($lockout_until && $now < $lockout_until) {
            $diff = $lockout_until->getTimestamp() - $now->getTimestamp();
            $minutes = ceil($diff / 60);
            $error = "Account locked. Please try again after $minutes minute(s).";
        } else {
            // Task 2: Password Encryption စစ်ဆေးခြင်း
            if (password_verify($password, $user['password'])) {
                // Success: Failed attempts ကို reset ပြန်လုပ်ခြင်း
                $pdo->prepare("UPDATE users SET failed_attempts = 0, lockout_until = NULL WHERE id = ?")
                    ->execute([$user['id']]);
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role']; // Admin သို့မဟုတ် User သိမ်းဆည်းခြင်း
                $_SESSION['user_name'] = $user['first_name'];

                // Role အလိုက် စာမျက်နှာခွဲပို့ခြင်း
                if ($user['role'] === 'admin') {
                    header("Location: ../admin/index.php");
                } else {
                    header("Location: ../index.php");
                }
                exit();
            } else {
                // Failure: Failed attempts ကို တိုးမြှင့်ခြင်း 
                $attempts = $user['failed_attempts'] + 1;
                $new_lockout = null;

                if ($attempts >= 3) {
                    // Task 2: ၃ ကြိမ်မှားပါက ၃ မိနစ် Lock ချခြင်း
                    $new_lockout = (new DateTime())->modify('+3 minutes')->format('Y-m-d H:i:s');
                    $error = "Too many failed attempts. Account locked for 3 minutes.";
                } else {
                    $error = "Invalid password. Attempt: $attempts of 3.";
                }

                $pdo->prepare("UPDATE users SET failed_attempts = ?, lockout_until = ? WHERE id = ?")
                    ->execute([$attempts, $new_lockout, $user['id']]);
            }
        }
    } else {
        $error = "User not found with this email.";
    }
}

include '../includes/header.php'; 
?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl border border-slate-100">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-slate-900">Welcome Back</h2>
            <p class="mt-2 text-center text-sm text-slate-600">Login to your FoodFusion account</p>
            
            <?php if ($error): ?>
                <div class="mt-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-100">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <form class="mt-8 space-y-6" action="" method="POST">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email Address</label>
                    <input name="email" type="email" required 
                        class="w-full mt-1 px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all" 
                        placeholder="email@example.com">
                </div>
                
                <div class="relative">
                    <label class="block text-sm font-medium text-slate-700">Password</label>
                    <div class="relative mt-1">
                        <input id="login-password" name="password" type="password" required 
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all pr-12">
                        
                        <button type="button" onclick="toggleLoginPassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-emerald-600 transition-colors">
                            <svg id="login-eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.399 8.049 7.21 5 12 5c4.789 0 8.601 3.049 9.964 6.322a1.012 1.012 0 010 .644C20.601 15.951 16.79 19 12 19c-4.79 0-8.601-3.049-9.964-6.322z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full py-3.5 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 shadow-md transition-all focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    Sign In
                </button>
            </div>
            
            <p class="text-center text-sm text-slate-600">
                Don't have an account? <a href="../index.php" class="text-emerald-600 font-semibold hover:text-emerald-500">Register here</a>
            </p>
        </form>
    </div>
</div>

<script>
function toggleLoginPassword() {
    const passwordField = document.getElementById('login-password');
    const eyeIcon = document.getElementById('login-eye-icon');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />`;
    } else {
        passwordField.type = 'password';
        eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.399 8.049 7.21 5 12 5c4.789 0 8.601 3.049 9.964 6.322a1.012 1.012 0 010 .644C20.601 15.951 16.79 19 12 19c-4.79 0-8.601-3.049-9.964-6.322z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
    }
}
</script>