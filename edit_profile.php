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

// Fetch current data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = strip_tags(trim($_POST['first_name']));
    $last_name = strip_tags(trim($_POST['last_name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    if (!empty($first_name) && !empty($last_name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $update = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?");
            $update->execute([$first_name, $last_name, $email, $user_id]);
            $success = "Profile updated successfully.";
            
            // Refresh local user data
            $user['first_name'] = $first_name;
            $user['last_name'] = $last_name;
            $user['email'] = $email;
        } catch (PDOException $e) {
            $error = "Email already in use or database error.";
        }
    } else {
        $error = "Please fill in all fields correctly.";
    }
}

include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<div class="bg-stone-50 min-h-screen pt-32 pb-24">
    <div class="max-w-4xl mx-auto px-6">
        
        <div class="mb-12">
            <a href="dashboard.php" class="text-[10px] font-black uppercase tracking-widest text-stone-400 hover:text-emerald-600 transition-colors flex items-center gap-2 mb-6">
                ← Back to Dashboard
            </a>
            <h1 class="text-4xl font-serif text-stone-900 italic">Account Settings</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <div class="lg:col-span-1">
                <div class="bg-white p-10 rounded-[3rem] border border-stone-100 text-center shadow-sm">
                    <div class="w-24 h-24 bg-emerald-900 rounded-[2rem] flex items-center justify-center text-white text-3xl font-black mx-auto mb-6 shadow-xl shadow-emerald-900/20">
                        <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
                    </div>
                    <h3 class="font-bold text-stone-800"><?php echo htmlspecialchars($user['first_name']); ?></h3>
                    <p class="text-[10px] text-stone-400 uppercase tracking-widest font-black mt-1">Community Member</p>
                    
                    <button class="mt-8 text-[9px] font-black uppercase tracking-widest text-emerald-600 border border-emerald-100 px-6 py-3 rounded-xl hover:bg-emerald-600 hover:text-white transition-all">
                        Change Avatar
                    </button>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white p-10 md:p-16 rounded-[3rem] border border-stone-100 shadow-sm">
                    
                    <?php if($success): ?>
                        <div class="mb-8 p-4 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-2xl border border-emerald-100">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <?php if($error): ?>
                        <div class="mb-8 p-4 bg-red-50 text-red-700 text-xs font-bold rounded-2xl border border-red-100">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST" class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-[10px] font-black uppercase text-stone-400 mb-3 tracking-widest">First Name</label>
                                <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" 
                                       class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none ring-1 ring-stone-200 focus:ring-2 focus:ring-emerald-500 transition-all outline-none font-medium">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase text-stone-400 mb-3 tracking-widest">Last Name</label>
                                <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" 
                                       class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none ring-1 ring-stone-200 focus:ring-2 focus:ring-emerald-500 transition-all outline-none font-medium">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase text-stone-400 mb-3 tracking-widest">Email Address</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" 
                                   class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none ring-1 ring-stone-200 focus:ring-2 focus:ring-emerald-500 transition-all outline-none font-medium">
                        </div>

                        <div class="pt-6 border-t border-stone-50">
                            <button type="submit" class="w-full md:w-auto px-12 py-5 bg-stone-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-emerald-800 transition-all shadow-xl shadow-stone-900/10">
                                Update Profile
                            </button>
                        </div>
                    </form>

                    <div class="mt-16 pt-12 border-t border-stone-100">
                        <h4 class="text-lg font-serif italic text-stone-800 mb-6">Security</h4>
                        <a href="change_password.php" class="inline-flex items-center gap-3 text-stone-400 hover:text-red-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="text-[10px] font-black uppercase tracking-widest">Update Password</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>