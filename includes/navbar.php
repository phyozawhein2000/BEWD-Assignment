<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div id="joinModal" class="fixed inset-0 z-[200] hidden flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-[2.5rem] max-w-md w-full p-8 shadow-2xl transform transition-all scale-95 opacity-0" id="modalContent">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-black text-emerald-800 tracking-tight uppercase">Join FoodFusion</h2>
                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-1">Create your chef account</p>
            </div>
            <button onclick="closeModal()" class="p-2 bg-stone-100 rounded-full text-stone-400 hover:text-stone-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div id="regMessage" class="hidden mb-4"></div>

        <form id="regForm" class="space-y-4">
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-stone-400 ml-4">First Name</label>
                    <input type="text" name="first_name" required placeholder="first name" 
                           class="w-full bg-stone-50 border border-stone-100 rounded-2xl px-5 py-3.5 text-sm focus:outline-none focus:border-emerald-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-stone-400 ml-4">Last Name</label>
                    <input type="text" name="last_name" required placeholder="last name" 
                           class="w-full bg-stone-50 border border-stone-100 rounded-2xl px-5 py-3.5 text-sm focus:outline-none focus:border-emerald-500 transition-all">
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase tracking-widest text-stone-400 ml-4">Email Address</label>
                <input type="email" name="email" required placeholder="example@gmail.com" 
                       class="w-full bg-stone-50 border border-stone-100 rounded-2xl px-5 py-4 text-sm focus:outline-none focus:border-emerald-500 transition-all">
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase tracking-widest text-stone-400 ml-4">Password</label>
                <div class="relative">
                    <input id="regPassword" type="password" name="password" required placeholder="••••••••" 
                           class="w-full bg-stone-50 border border-stone-100 rounded-2xl px-5 py-4 text-sm focus:outline-none focus:border-emerald-500 transition-all">
                    <button type="button" onclick="toggleRegPassword()" class="absolute right-4 top-4 text-stone-400 hover:text-emerald-600">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" id="regBtn" class="w-full bg-emerald-800 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-emerald-900/20 hover:bg-stone-900 transition-all mt-2 active:scale-[0.98]">
                Create Account
            </button>
        </form>

        <p class="text-center text-[11px] font-bold text-stone-400 mt-8 pt-6 border-t border-stone-50 uppercase tracking-widest">
            Already a member? <a href="auth/login.php" class="text-emerald-800 hover:underline">Login here</a>
        </p>
    </div>
</div>

<div class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-xl border-t border-stone-100 z-[100] px-4 pb-6 pt-3 flex justify-around items-center shadow-[0_-10px_30px_rgba(0,0,0,0.05)]">
    <a href="index.php" class="flex flex-col items-center transition-all <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'text-emerald-800' : 'text-stone-400'; ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
        <span class="text-[10px] font-black uppercase mt-1 tracking-wider">Home</span>
    </a>
    <a href="recipes.php" class="flex flex-col items-center text-stone-400 hover:text-emerald-800 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
        <span class="text-[10px] font-black uppercase mt-1 tracking-wider">Recipes</span>
    </a>
    
    <button onclick="toggleMobileSidebar()" class="relative -mt-12 transition-transform active:scale-90">
        <div class="bg-emerald-800 text-white p-4 rounded-full shadow-xl shadow-emerald-900/40 ring-4 ring-white">
            <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </div>
    </button>

    <a href="community.php" class="flex flex-col items-center text-stone-400 hover:text-emerald-800 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        <span class="text-[10px] font-black uppercase mt-1 tracking-wider">Social</span>
    </a>
    <a href="<?php echo isset($_SESSION['user_id']) ? 'profile.php' : 'auth/login.php'; ?>" class="flex flex-col items-center text-stone-400 hover:text-emerald-800 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
        <span class="text-[10px] font-black uppercase mt-1 tracking-wider">Profile</span>
    </a>
</div>

<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-stone-100">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        <a href="index.php" class="relative group">
            <h1 class="text-2xl font-black tracking-tighter text-emerald-800">FOODFUSION</h1>
            <div class="absolute -bottom-1 left-0 w-0 h-1 bg-emerald-800 transition-all group-hover:w-full"></div>
        </a>

        <div class="hidden md:flex items-center space-x-8 text-[13px] font-bold tracking-widest uppercase">
            <a href="index.php" class="text-emerald-800 hover:opacity-70 transition">Home</a>
            <a href="recipes.php" class="text-stone-500 hover:text-emerald-800 transition">Recipes</a>
            <a href="community.php" class="text-stone-500 hover:text-emerald-800 transition">Community</a>
            <a href="resources.php" class="text-stone-500 hover:text-emerald-800 transition">Resources</a>
            <a href="aboutus.php" class="text-stone-500 hover:text-emerald-800 transition">AboutUs</a>
            <a href="contact.php" class="text-stone-500 hover:text-emerald-800 transition">ContactUs</a>
        </div>

        <div class="hidden md:flex items-center space-x-6">
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="flex items-center space-x-4 border-r pr-6 border-stone-200">
                    <div class="text-right">
                        <p class="text-[10px] uppercase font-bold text-stone-400 mb-0.5">Welcome back,</p>
                        <a href="profile.php" class="text-sm font-black text-stone-800 leading-none"><?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                    </div>
                    <?php if($_SESSION['role'] === 'admin'): ?>
                        <a href="admin/index.php" class="bg-amber-100 text-amber-700 p-2 rounded-xl hover:bg-amber-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg>
                        </a>
                    <?php endif; ?>
                </div>
                <a href="auth/logout.php" class="text-sm font-bold text-red-500 hover:underline">Logout</a>
            <?php else: ?>
                <button onclick="openModal()" class="bg-emerald-800 text-white px-8 py-3 rounded-full text-sm font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-900/20 transition active:scale-95">
                    Join Us
                </button>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div id="sidebarOverlay" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-stone-900/40 backdrop-blur-sm z-[110] hidden opacity-0 transition-opacity duration-300"></div>

<aside id="mobileSidebar" class="fixed inset-y-0 right-0 w-[85%] max-w-xs bg-white z-[120] translate-x-full transition-transform duration-300 ease-in-out md:hidden shadow-2xl overflow-y-auto">
    <div class="p-8 flex flex-col h-full">
        <div class="flex justify-between items-center mb-10">
            <span class="text-[10px] font-black text-stone-300 uppercase tracking-[0.2em]">Navigation</span>
            <button onclick="toggleMobileSidebar()" class="p-2 bg-stone-100 rounded-full text-stone-500 transition-colors hover:bg-stone-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <nav class="space-y-1">
            <a href="resources.php" class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-emerald-50 text-stone-700 font-bold group transition-all">
                <span class="bg-stone-100 p-2 rounded-xl group-hover:bg-emerald-100 group-hover:text-emerald-800">📚</span>
                <span>Resources</span>
            </a>
            <a href="aboutus.php" class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-emerald-50 text-stone-700 font-bold group transition-all">
                <span class="bg-stone-100 p-2 rounded-xl group-hover:bg-emerald-100 group-hover:text-emerald-800">👋</span>
                <span>About Us</span>
            </a>
            <a href="contact.php" class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-emerald-50 text-stone-700 font-bold group transition-all">
                <span class="bg-stone-100 p-2 rounded-xl group-hover:bg-emerald-100 group-hover:text-emerald-800">📧</span>
                <span>Contact</span>
            </a>
        </nav>

        <div class="mt-auto pt-8 border-t border-stone-100">
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="flex items-center space-x-4 mb-6">
                    <div class="h-12 w-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-800 font-bold text-xl uppercase">
                        <?php echo substr($_SESSION['user_name'], 0, 1); ?>
                    </div>
                    <div>
                        <p class="text-xs text-stone-400 font-bold uppercase">Account</p>
                        <p class="font-bold text-stone-800"><?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                    </div>
                </div>
                <a href="auth/logout.php" class="block w-full text-center py-4 rounded-2xl bg-red-50 text-red-600 font-bold">Logout</a>
            <?php else: ?>
                <div class="grid grid-cols-1 gap-3">
                    <button onclick="toggleMobileSidebar(); openModal();" class="bg-emerald-800 text-white text-center py-4 rounded-2xl font-bold shadow-lg shadow-emerald-900/20 active:scale-95 transition-all">Sign Up Free</button>
                    <a href="auth/login.php" class="text-stone-500 text-center py-3 font-bold hover:text-emerald-800 transition-colors">Sign In</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</aside>

<script>
    // Sidebar Control
    function toggleMobileSidebar() {
        const sidebar = document.getElementById('mobileSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const isClosed = sidebar.classList.contains('translate-x-full');

        if (isClosed) {
            sidebar.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
            document.body.style.overflow = 'hidden';
        } else {
            sidebar.classList.add('translate-x-full');
            overlay.classList.remove('opacity-100');
            setTimeout(() => overlay.classList.add('hidden'), 300);
            document.body.style.overflow = 'auto';
        }
    }

    // Modal Control
    function openModal() {
        const modal = document.getElementById('joinModal');
        const content = document.getElementById('modalContent');
        modal.classList.remove('hidden');
        setTimeout(() => content.classList.remove('scale-95', 'opacity-0'), 10);
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('joinModal');
        const content = document.getElementById('modalContent');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { modal.classList.add('hidden'); document.body.style.overflow = 'auto'; }, 200);
    }

    // Password Visibility
    function toggleRegPassword() {
        const pInput = document.getElementById('regPassword');
        pInput.type = pInput.type === 'password' ? 'text' : 'password';
    }

    // AJAX Form Submission
    document.getElementById('regForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('regBtn');
        const msgDiv = document.getElementById('regMessage');
        const formData = new FormData(this);

        btn.innerText = "Creating Account...";
        btn.disabled = true;

        fetch('auth/register_process.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            msgDiv.classList.remove('hidden');
            if(data.status === 'success') {
                msgDiv.innerHTML = `<div class="p-4 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-2xl border border-emerald-100">${data.message}</div>`;
                setTimeout(() => window.location.href = 'auth/login.php', 1500);
            } else {
                msgDiv.innerHTML = `<div class="p-4 bg-red-50 text-red-700 text-xs font-bold rounded-2xl border border-red-100">${data.message}</div>`;
                btn.innerText = "Create Account";
                btn.disabled = false;
            }
        }).catch(() => { btn.disabled = false; btn.innerText = "Create Account"; });
    });

    // Close on outside click
    window.onclick = function(e) { if (e.target == document.getElementById('joinModal')) closeModal(); }
</script>