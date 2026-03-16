<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php';

try {
    // အသစ်ဆုံးတင်ထားတဲ့ Recipe ၆ ခုကို ဆွဲထုတ်မယ်
    $stmt = $pdo->query("SELECT * FROM recipes ORDER BY created_at DESC LIMIT 6");
    $latest_recipes = $stmt->fetchAll();
} catch (PDOException $e) {
    $latest_recipes = [];
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

<section class="relative h-[90vh] w-full bg-stone-900 overflow-hidden">
    <div id="hero-slider" class="absolute inset-0">
        <div class="slide absolute inset-0 transition-all duration-[2500ms] ease-out opacity-100 scale-110">
            <img src="assets/img/slideshow1.jpg" class="w-full h-full object-cover grayscale-[0.2]" alt="Minimalist Food">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/60"></div>
        </div>
        <div class="slide absolute inset-0 transition-all duration-[2500ms] ease-out opacity-0 scale-100">
            <img src="assets/img/slideshow2.jpg" class="w-full h-full object-cover grayscale-[0.2]" alt="Salad">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/60"></div>
        </div>
    </div>

    <div class="relative z-20 flex flex-col items-center justify-center h-full text-center px-6">
    <span class="text-[10px] font-black uppercase tracking-[0.5em] text-emerald-400 mb-8 animate-fade-in">
        Est. 2024 • Culinary Arts
    </span>
    
    <h1 class="text-7xl md:text-[10rem] font-serif text-white leading-[0.85] tracking-tighter mb-8 animate-slide-up">
        Simply <br>
        <span class="italic font-light text-stone-300 ml-12">Delicious.</span>
    </h1>

    <p class="text-white/70 text-sm md:text-lg font-light tracking-[0.1em] max-w-lg mb-12 uppercase animate-fade-in delay-500">
        A curated collection of recipes for the <span class="text-white font-medium">modern home cook.</span>
    </p>

   <div class="flex flex-col sm:flex-row items-center gap-6 animate-fade-in delay-700">
    <a href="recipes.php" class="group relative px-12 py-5 overflow-hidden rounded-full border border-white/30 bg-white/10 backdrop-blur-md transition-all hover:bg-white hover:border-transparent">
        <span class="relative z-10 text-[10px] font-black uppercase tracking-[0.4em] text-white group-hover:text-black transition-colors">
            Enter Kitchen
        </span>
    </a>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <button onclick="openModal()" class="group px-12 py-5 rounded-full bg-emerald-800 text-white text-[10px] font-black uppercase tracking-[0.4em] hover:bg-emerald-700 shadow-xl shadow-emerald-900/20 transition-all active:scale-95 border border-emerald-700">
            Join Us
        </button>
    <?php endif; ?>
</div>
</div>

    <div class="absolute bottom-12 left-6 md:left-20 z-30 flex flex-col gap-6">
        <div class="group cursor-pointer flex items-center gap-4 overflow-hidden">
            <span class="nav-num text-xs font-bold text-white transition-all">01</span>
            <div class="h-[1px] w-8 bg-white/30 group-hover:w-16 transition-all duration-500"></div>
        </div>
        <div class="group cursor-pointer flex items-center gap-4 overflow-hidden">
            <span class="nav-num text-xs font-bold text-white/30 transition-all">02</span>
            <div class="h-[1px] w-8 bg-white/10 group-hover:w-16 transition-all duration-500"></div>
        </div>
    </div>
</section>

<main class="max-w-7xl mx-auto px-6 py-32 bg-white">
    <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
        <div class="max-w-xl">
            <span class="text-[10px] font-black tracking-[0.4em] uppercase text-emerald-600 block mb-4">The Seasonal List</span>
            <h2 class="text-5xl font-serif text-stone-900 leading-tight italic">Discover Our Latest <span class="text-stone-400 not-italic">Creations</span></h2>
        </div>
        <div class="hidden md:block">
            <a href="recipes.php" class="text-[10px] font-bold uppercase tracking-widest border-b-2 border-stone-900 pb-2 hover:text-emerald-600 hover:border-emerald-600 transition-all">Explore All Recipes</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-y-24 gap-x-12">
        <?php if (!empty($latest_recipes)): ?>
            <?php foreach ($latest_recipes as $index => $r): ?>
                <?php 
                    // ပုံစံကို တစ်လှည့်စီဖြစ်အောင် Grid span တွေကို တွက်ချက်ခြင်း
                    $isLarge = ($index % 3 == 0); // ၃ ခုမြောက်တိုင်းကို အကြီးပြမယ်
                    $colSpan = $isLarge ? 'md:col-span-4' : 'md:col-span-4';
                ?>
                
                <div class="<?php echo $colSpan; ?> group">
                    <a href="recipe_detail.php?id=<?php echo $r['recipe_id']; ?>" class="block">
                        <div class="relative aspect-[16/10] overflow-hidden rounded-[2rem] bg-stone-100 mb-8 shadow-2xl shadow-stone-200/50">
                            <img src="<?php echo htmlspecialchars($r['image_url']); ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.5s] ease-out"
                                 alt="<?php echo htmlspecialchars($r['title']); ?>">
                            
                            <div class="absolute top-8 left-8">
                                <span class="bg-white/10 backdrop-blur-xl border border-white/20 px-4 py-2 text-[9px] font-black uppercase tracking-widest text-white rounded-full">
                                    <?php echo htmlspecialchars($r['cuisine_type']); ?>
                                </span>
                            </div>

                            <div class="absolute inset-0 bg-emerald-950/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center backdrop-blur-[2px]">
                                <div class="text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 text-white">
                                    <p class="text-[10px] font-black uppercase tracking-[0.3em] mb-2">View Full Recipe</p>
                                    <div class="h-[1px] w-12 bg-white/50 mx-auto"></div>
                                </div>
                            </div>
                        </div>

                        <div class="px-2">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-[9px] font-black uppercase tracking-widest text-emerald-600"><?php echo htmlspecialchars($r['difficulty']); ?> Level</span>
                                <span class="w-1 h-1 bg-stone-300 rounded-full"></span>
                                <!-- <span class="text-[9px] font-black uppercase tracking-widest text-stone-400">30 Mins Prep</span> -->
                            </div>
                            <h3 class="text-3xl font-serif text-stone-800 leading-snug group-hover:text-emerald-700 transition-colors">
                                <?php echo htmlspecialchars($r['title']); ?>
                            </h3>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-12 py-32 text-center border-2 border-dashed border-stone-100 rounded-[3rem]">
                <p class="text-stone-400 italic font-serif text-xl">Our kitchen is currently prepping new magic.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<section class="bg-stone-50 py-32 border-t border-stone-100">
    <div class="max-w-2xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-serif text-stone-900 mb-6">Join the Table</h2>
        <p class="text-stone-500 mb-10 font-light">Get our best recipes delivered to your inbox once a month. No noise, just food.</p>
        
        <form id="newsletterForm" class="relative">
            <input type="email" id="subscriberEmail" name="email" required placeholder="Your email address" 
                   class="w-full bg-transparent border-b border-stone-300 py-4 outline-none focus:border-emerald-600 transition-colors text-center">
            
            <button type="submit" id="subBtn" class="mt-8 text-[10px] font-bold uppercase tracking-[0.3em] text-emerald-700 hover:text-emerald-500 transition-colors">
                Subscribe
            </button>
            
            <p id="subMessage" class="mt-4 text-[10px] font-bold uppercase tracking-widest hidden"></p>
        </form>
    </div>
</section>
<div id="cookie-overlay" class="fixed inset-0 bg-stone-900/60 backdrop-blur-sm z-[9999] flex items-center justify-center opacity-0 pointer-events-none transition-all duration-500">
    <div id="cookie-modal" class="bg-white max-w-sm w-[90%] p-10 rounded-[3rem] shadow-2xl text-center transform scale-90 transition-all duration-500">
        <div class="w-16 h-16 bg-orange-50 rounded-3xl flex items-center justify-center mx-auto mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>

        <h3 class="text-xl font-serif text-stone-900 mb-4 italic">Cookie Settings</h3>
        <p class="text-stone-500 text-sm font-light leading-relaxed mb-10">
            ကျွန်ုပ်တို့၏ ဝန်ဆောင်မှုများကို အကောင်းဆုံးအသုံးချနိုင်ရန် Cookies များကို လက်ခံပေးဖို့ လိုအပ်ပါသည်။
        </p>

        <div class="flex flex-col gap-3">
            <button id="accept-cookies" class="w-full bg-stone-900 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-orange-600 transition-colors shadow-lg shadow-stone-900/20">
                Accept All
            </button>
            <button id="decline-cookies" class="w-full py-4 text-[10px] font-black uppercase tracking-[0.2em] text-stone-400 hover:text-stone-900 transition-colors">
                Necessary Only
            </button>
        </div>

        <p class="mt-8 text-[9px] text-stone-300 uppercase tracking-widest leading-loose">
            Read our <a href="privacy.php" class="underline hover:text-orange-500">Privacy Policy</a>
        </p>
    </div>
</div>

<script>
document.getElementById('newsletterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('subscriberEmail').value;
    const btn = document.getElementById('subBtn');
    const msg = document.getElementById('subMessage');

    btn.innerText = 'Processing...';

    // AJAX နဲ့ Data ပို့ခြင်း
    fetch('subscribe_process.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'email=' + encodeURIComponent(email)
    })
    .then(response => response.json())
    .then(data => {
        msg.classList.remove('hidden', 'text-red-500', 'text-emerald-600');
        msg.innerText = data.message;
        
        if(data.status === 'success') {
            msg.classList.add('text-emerald-600');
            document.getElementById('subscriberEmail').value = '';
            btn.innerText = 'Thank You';
        } else {
            msg.classList.add('text-red-500');
            btn.innerText = 'Subscribe';
        }
    });
});

    let current = 0;
    const slides = document.querySelectorAll('.slide');
    const bars = document.querySelectorAll('.progress-line');

    function animateBar(index) {
        bars.forEach(b => b.style.width = '0');
        let width = 0;
        const interval = setInterval(() => {
            if (width >= 100) {
                clearInterval(interval);
                nextSlide();
            } else {
                width++;
                bars[index].style.width = width + '%';
            }
        }, 50); // 5 seconds total
    }
function nextSlide() {
    // လက်ရှိ slide ကို ပျောက်စေပြီး scale လျှော့မယ်
    slides[current].style.opacity = '0';
    slides[current].classList.remove('scale-110');
    slides[current].classList.add('scale-100');

    current = (current + 1) % slides.length;

    // slide အသစ်ကို ပေါ်လာစေပြီး scale ချဲ့မယ် (Ken Burns Effect)
    slides[current].style.opacity = '1';
    slides[current].classList.remove('scale-100');
    slides[current].classList.add('scale-110');
    
    // Pagination နံပါတ်တွေကို အရောင်ပြောင်းမယ်
    document.querySelectorAll('.nav-num').forEach((el, i) => {
        el.style.opacity = (i === current) ? '1' : '0.3';
    });
}

    animateBar(0);
 
document.addEventListener("DOMContentLoaded", function() {
    const overlay = document.getElementById('cookie-overlay');
    const modal = document.getElementById('cookie-modal');
    const acceptBtn = document.getElementById('accept-cookies');
    const declineBtn = document.getElementById('decline-cookies');

    // Consent မရှိသေးရင် ပြမယ်
    if (!localStorage.getItem('cookie_consent')) {
        setTimeout(() => {
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
            modal.classList.remove('scale-90');
            modal.classList.add('scale-100');
        }, 1000);
    }

    // ပိတ်တဲ့ Function
    function closeCookieModal() {
        modal.classList.remove('scale-100');
        modal.classList.add('scale-90');
        overlay.classList.remove('opacity-100');
        overlay.classList.add('opacity-0', 'pointer-events-none');
        setTimeout(() => overlay.remove(), 600);
    }

    acceptBtn.addEventListener('click', () => {
        localStorage.setItem('cookie_consent', 'accepted');
        closeCookieModal();
    });

    declineBtn.addEventListener('click', () => {
        localStorage.setItem('cookie_consent', 'essential');
        closeCookieModal();
    });
});
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
</script>

<style>
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-up { animation: slide-up 1.2s ease forwards; }
    
    /* Remove default button styles */
    input::placeholder { color: #a8a29e; font-size: 0.8rem; letter-spacing: 0.1em; text-transform: uppercase; }
</style>

<?php include 'includes/footer.php'; ?>

