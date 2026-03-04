<?php 
require_once '../config/db.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = trim($_POST['first_name']);
    $lname = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $raw_password = $_POST['password'];

    // Task 2: Implement Password Encryption using BCRYPT
    $hashed_password = password_hash($raw_password, PASSWORD_BCRYPT);

    try {
        // အရင်ဆုံး Email ရှိမရှိ စစ်ဆေးခြင်း
        $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->execute([$email]);
        
        if ($checkEmail->rowCount() > 0) {
            $message = "<div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50'>Email is already registered!</div>";
        } else {
            // Database ထဲသို့ သိမ်းဆည်းခြင်း
            $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$fname, $lname, $email, $hashed_password])) {
                $message = "<div class='p-4 mb-4 text-sm text-emerald-800 rounded-lg bg-emerald-50'>Account created successfully! <a href='login.php' class='font-bold underline'>Login now</a></div>";
            }
        }
    } catch (PDOException $e) {
        $message = "<div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50'>Error: " . $e->getMessage() . "</div>";
    }
}

include '../includes/header.php'; 
?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl border border-slate-100">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Join FoodFusion</h2>
            <p class="mt-2 text-sm text-slate-500">Create your account to share and discover recipes</p>
            <div class="mt-6"><?php echo $message; ?></div>
        </div>
        
        <form class="mt-8 space-y-4" action="" method="POST">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">First Name</label>
                    <input name="first_name" type="text" required 
                        class="w-full mt-1 px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Last Name</label>
                    <input name="last_name" type="text" required 
                        class="w-full mt-1 px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700">Email Address</label>
                <input name="email" type="email" required 
                    class="w-full mt-1 px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all" 
                    placeholder="user@example.com">
            </div>
            
            <div class="relative">
                <label class="block text-sm font-medium text-slate-700">Password</label>
                <div class="relative mt-1">
                    <input id="password" name="password" type="password" required 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all pr-12">
                    
                    <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-emerald-600 transition-colors">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.399 8.049 7.21 5 12 5c4.789 0 8.601 3.049 9.964 6.322a1.012 1.012 0 010 .644C20.601 15.951 16.79 19 12 19c-4.79 0-8.601-3.049-9.964-6.322z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                Create Account
            </button>

            <div class="text-center mt-6">
                <p class="text-sm text-slate-600">
                    Already have an account? <a href="login.php" class="text-emerald-600 font-semibold hover:text-emerald-500 transition-colors">Sign In</a>
                </p>
            </div>
        </form>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        // Eye-slash icon (Visibility Off)
        eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />`;
    } else {
        passwordField.type = 'password';
        // Normal eye icon (Visibility On)
        eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.399 8.049 7.21 5 12 5c4.789 0 8.601 3.049 9.964 6.322a1.012 1.012 0 010 .644C20.601 15.951 16.79 19 12 19c-4.79 0-8.601-3.049-9.964-6.322z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
    }
}
</script>
