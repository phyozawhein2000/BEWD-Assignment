<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php';

try {
    // Fetch 6 latest recipes
    $stmt = $pdo->query("SELECT * FROM recipes ORDER BY created_at DESC LIMIT 6");
    $latest_recipes = $stmt->fetchAll();
} catch (PDOException $e) {
    $latest_recipes = [];
}
?>

<div id="joinModal" onclick="closeModal()" class="fixed inset-0 z-[200] hidden flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-all duration-300">
    <div class="bg-white rounded-[2.5rem] max-w-md w-full p-8 shadow-2xl transform transition-all scale-95 opacity-0 relative" id="modalContent" onclick="event.stopPropagation()">
        
        <button onclick="closeModal()" class="absolute top-6 right-6 text-stone-300 hover:text-stone-900 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>

        <h3 class="text-2xl font-serif mb-6 italic text-stone-900">Join the Community</h3>
        <div id="regMessage" class="hidden mb-4 p-4 rounded-xl text-xs font-bold"></div>

        <form id="regForm" class="space-y-4">
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-stone-400 ml-4">First Name</label>
                    <input type="text" name="first_name" required placeholder="First Name" 
                           class="w-full bg-stone-50 border border-stone-100 rounded-2xl px-5 py-3.5 text-sm focus:outline-none focus:border-emerald-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-stone-400 ml-4">Last Name</label>
                    <input type="text" name="last_name" required placeholder="Last Name" 
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

<section class="relative h-screen w-full bg-stone-900 overflow-hidden">
    <div id="hero-slider" class="absolute inset-0">
        <div class="slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-100 scale-110">
            <img src="assets/img/slideshow1.jpg" class="w-full h-full object-cover grayscale-[0.2]" alt="Minimalist Food">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/60"></div>
        </div>
        <div class="slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-0 scale-100">
            <img src="assets/img/slideshow2.jpg" class="w-full h-full object-cover grayscale-[0.2]" alt="Salad">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/60"></div>
        </div>      
    </div>

    <div class="relative z-20 flex flex-col items-center justify-center h-full text-center px-6">
        <div class="flex items-center gap-4 mb-8 animate-fade-in">
            <div class="h-[1px] w-8 bg-emerald-500/50"></div>
            <span class="text-[9px] font-black uppercase tracking-[0.6em] text-emerald-400">Est. 2026 • The Art of Fusion</span>
            <div class="h-[1px] w-8 bg-emerald-500/50"></div>
        </div>
        
        <h1 class="text-8xl md:text-[11rem] font-serif text-white leading-[0.8] tracking-tighter mb-10">
            <span class="block animate-slide-up">Simply</span>
            <span class="block italic font-light text-stone-300 md:ml-32 animate-slide-up delay-200">Delicious.</span>
        </h1>

        <div class="relative max-w-2xl p-8 rounded-[2.5rem] bg-white/[0.03] backdrop-blur-sm border border-white/10 mb-12 animate-fade-in delay-500">
            <p class="text-white/70 text-[11px] md:text-xs font-medium tracking-[0.2em] uppercase leading-loose">
                To empower every home cook by bridging the gap between <br class="hidden md:block">
                <span class="text-emerald-400">diverse culinary traditions</span> and modern convenience.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-4 animate-fade-in delay-700">
            <a href="recipes.php" class="group relative px-14 py-5 overflow-hidden rounded-2xl border border-white/20 bg-white/5 transition-all hover:bg-white">
                <span class="relative z-10 text-[10px] font-black uppercase tracking-[0.4em] text-white group-hover:text-emerald-950 transition-colors">
                    Explore Recipes
                </span>
            </a>

            <?php if (!isset($_SESSION['user_id'])): ?>
                <button onclick="openModal()" class="group px-14 py-6 rounded-2xl bg-emerald-800 text-white text-[10px] font-black uppercase tracking-[0.4em] hover:bg-emerald-700 shadow-2xl shadow-emerald-900/40 transition-all active:scale-95 border border-emerald-700">
                    Join Us
                </button>
            <?php endif; ?>
        </div>

        
    </div>
</section>

<main class="max-w-7xl mx-auto px-6 py-32 bg-white">
    <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
        <div class="max-w-xl">
            <span class="text-[10px] font-black tracking-[0.4em] uppercase text-emerald-600 block mb-4">The Seasonal List</span>
            <h2 class="text-5xl font-serif text-stone-900 leading-tight italic">Latest <span class="text-stone-400 not-italic">Creations</span></h2>
        </div>
        <a href="recipes.php" class="text-[10px] font-bold uppercase tracking-widest border-b-2 border-stone-900 pb-2 hover:text-emerald-600 hover:border-emerald-600 transition-all">View All Recipes</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-y-20 gap-x-12">
        <?php if (!empty($latest_recipes)): ?>
            <?php foreach ($latest_recipes as $index => $r): ?>
                <div class="md:col-span-4 group">
                    <a href="recipe_detail.php?id=<?= $r['recipe_id']; ?>" class="block">
                        <div class="relative aspect-[16/10] overflow-hidden rounded-[2rem] bg-stone-100 mb-8 shadow-2xl shadow-stone-200/50">
                            <img src="<?= htmlspecialchars($r['image_url']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.5s] ease-out">
                            <div class="absolute top-8 left-8">
                                <span class="bg-black/20 backdrop-blur-xl border border-white/20 px-4 py-2 text-[9px] font-black uppercase tracking-widest text-white rounded-full"><?= htmlspecialchars($r['cuisine_type']); ?></span>
                            </div>
                        </div>
                        <div class="px-2">
                            <span class="text-[9px] font-black uppercase tracking-widest text-emerald-600"><?= htmlspecialchars($r['difficulty']); ?> Level</span>
                            <h3 class="text-2xl font-serif text-stone-800 mt-2 group-hover:text-emerald-700 transition-colors"><?= htmlspecialchars($r['title']); ?></h3>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-12 py-20 text-center border-2 border-dashed border-stone-100 rounded-[3rem]">
                <p class="text-stone-400 italic font-serif">Kitchen is currently prepping new magic...</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<section class="bg-emerald-900 py-32 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 mb-16 flex justify-between items-center">
        <h2 class="text-4xl font-serif text-white italic">Upcoming <span class="text-emerald-400">Events</span></h2>
        <div class="flex gap-4">
            <button id="prevEvent" class="w-12 h-12 border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white hover:text-emerald-900 transition-all">←</button>
            <button id="nextEvent" class="w-12 h-12 border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white hover:text-emerald-900 transition-all">→</button>
        </div>
    </div>
    <div id="event-track" class="flex transition-transform duration-700 ease-in-out px-6 gap-8">
        <div class="min-w-[350px] bg-white/5 border border-white/10 p-10 rounded-[2.5rem] backdrop-blur-md">
            <span class="text-emerald-400 text-[10px] font-black tracking-widest uppercase">March 24, 2026</span>
            <h4 class="text-white text-2xl font-serif mt-4 italic">Sushi Fusion Workshop</h4>
            <p class="text-white/50 text-xs mt-4 leading-relaxed font-light">Join Chef Tanaka for a masterclass in blending Japanese precision with local flavors.</p>
            <a href="#" class="inline-block mt-8 text-white text-[9px] font-bold uppercase tracking-widest border-b border-emerald-500 pb-1">Reserve Spot</a>
        </div>
        <div class="min-w-[350px] bg-white/5 border border-white/10 p-10 rounded-[2.5rem] backdrop-blur-md">
            <span class="text-emerald-400 text-[10px] font-black tracking-widest uppercase">April 05, 2026</span>
            <h4 class="text-white text-2xl font-serif mt-4 italic">Organic Farm to Table</h4>
            <p class="text-white/50 text-xs mt-4 leading-relaxed font-light">A rooftop dining experience highlighting Myanmar’s seasonal spring harvest.</p>
            <a href="#" class="inline-block mt-8 text-white text-[9px] font-bold uppercase tracking-widest border-b border-emerald-500 pb-1">Reserve Spot</a>
        </div>
        <div class="min-w-[350px] bg-white/5 border border-white/10 p-10 rounded-[2.5rem] backdrop-blur-md">
            <span class="text-emerald-400 text-[10px] font-black tracking-widest uppercase">April 12, 2026</span>
            <h4 class="text-white text-2xl font-serif mt-4 italic">Culinary Mastery: Fusion Basics</h4>
            <p class="text-white/50 text-xs mt-4 leading-relaxed font-light">Learn the fundamental techniques of blending Eastern spices with Western cooking styles.</p>
            <a href="#" class="inline-block mt-8 text-white text-[9px] font-bold uppercase tracking-widest border-b border-emerald-500 pb-1">Reserve Spot</a>
        </div>
        </div>
</section>

<section class="bg-stone-50 py-32 border-t border-stone-100">
    <div class="max-w-2xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-serif text-stone-900 mb-6 italic">Join the Table</h2>
        <p class="text-stone-500 mb-10 font-light">Get our best recipes delivered to your inbox once a month.</p>
        <form id="newsletterForm" class="relative">
            <input type="email" id="subscriberEmail" required placeholder="Your email address" 
                   class="w-full bg-transparent border-b border-stone-300 py-4 outline-none focus:border-emerald-600 transition-colors text-center uppercase text-[10px] tracking-widest">
            <button type="submit" id="subBtn" class="mt-8 text-[10px] font-bold uppercase tracking-[0.3em] text-emerald-700 hover:text-emerald-500 transition-colors">Subscribe</button>
            <p id="subMessage" class="mt-4 text-[10px] font-bold uppercase tracking-widest hidden"></p>
        </form>
    </div>
</section>

<div id="cookie-overlay" class="fixed inset-0 bg-stone-900/60 backdrop-blur-sm z-[9999] flex items-center justify-center opacity-0 pointer-events-none transition-all duration-500">
    <div id="cookie-modal" class="bg-white max-w-sm w-[90%] p-10 rounded-[3rem] shadow-2xl text-center transform scale-90 transition-all duration-500">
        <h3 class="text-xl font-serif text-stone-900 mb-4 italic">Privacy Settings</h3>
        <p class="text-stone-500 text-xs font-light leading-relaxed mb-10">We use cookies to ensure you get the best experience on FoodFusion.</p>
        <div class="flex flex-col gap-3">
            <button id="accept-cookies" class="w-full bg-emerald-800 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg">Accept All</button>
            <button id="decline-cookies" class="w-full py-4 text-[10px] font-black uppercase tracking-[0.2em] text-stone-400">Necessary Only</button>
        </div>
    </div>
</div>

<script>
// --- MODAL LOGIC ---
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
    setTimeout(() => { modal.classList.add('hidden'); document.body.style.overflow = 'auto'; }, 300);
}

// --- HERO SLIDER ---
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    if(slides.length > 0) {
        let currentSlide = 0;
        setInterval(() => {
            slides[currentSlide].classList.remove('opacity-100', 'scale-110');
            slides[currentSlide].classList.add('opacity-0', 'scale-100');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.remove('opacity-0', 'scale-100');
            slides[currentSlide].classList.add('opacity-100', 'scale-110');
        }, 5000);
    }
});

// --- EVENT CAROUSEL ---
const track = document.getElementById('event-track');
const nextBtn = document.getElementById('nextEvent');
const prevBtn = document.getElementById('prevEvent');
let scrollPos = 0;

nextBtn.addEventListener('click', () => {
    scrollPos -= 382; // Card width + gap
    if(scrollPos < -764) scrollPos = 0;
    track.style.transform = `translateX(${scrollPos}px)`;
});

prevBtn.addEventListener('click', () => {
    scrollPos += 382;
    if(scrollPos > 0) scrollPos = -764;
    track.style.transform = `translateX(${scrollPos}px)`;
});

// --- COOKIE CONSENT ---
document.addEventListener("DOMContentLoaded", function() {
    const overlay = document.getElementById('cookie-overlay');
    if (!localStorage.getItem('cookie_consent')) {
        setTimeout(() => {
            overlay.classList.replace('opacity-0', 'opacity-100');
            overlay.classList.remove('pointer-events-none');
        }, 1500);
    }
    document.getElementById('accept-cookies').onclick = () => {
        localStorage.setItem('cookie_consent', 'accepted');
        overlay.classList.add('opacity-0', 'pointer-events-none');
    };
});
</script>

<style>
    @keyframes slide-up { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slide-up { animation: slide-up 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .animate-fade-in { animation: opacity 1.5s ease forwards; }
    @keyframes opacity { from { opacity: 0; } to { opacity: 1; } }
</style>

<?php include 'includes/footer.php'; ?>