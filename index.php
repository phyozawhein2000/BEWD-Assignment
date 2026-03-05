<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php';

try {
    // အသစ်ဆုံးတင်ထားတဲ့ Recipe ၄ ခုကို ဆွဲထုတ်မယ်
    $stmt = $pdo->query("SELECT * FROM recipes ORDER BY created_at DESC LIMIT 4");
    $latest_recipes = $stmt->fetchAll();
} catch (PDOException $e) {
    $latest_recipes = [];
}
?>

<section class="relative h-[85vh] w-full bg-white overflow-hidden">
    <div id="hero-slider" class="absolute inset-0">
        <div class="slide absolute inset-0 transition-opacity duration-[2000ms] opacity-100">
            <img src="assets/img/slideshow1.jpg" class="w-full h-full object-cover" alt="Minimalist Food">
            <div class="absolute inset-0 bg-black/20"></div>
        </div>
        <div class="slide absolute inset-0 transition-opacity duration-[2000ms] opacity-0">
            <img src="assets/img/slideshow2.jpg" class="w-full h-full object-cover" alt="Salad">
            <div class="absolute inset-0 bg-black/20"></div>
        </div>
    </div>

    <div class="relative z-20 flex flex-col items-center justify-center h-full text-center px-6">
        <h1 class="text-6xl md:text-9xl font-serif text-white tracking-tight mb-6 animate-slide-up">
            Simply <span class="italic text-emerald-300">Delicious.</span>
        </h1>
        <p class="text-white/90 text-lg md:text-xl font-light tracking-wide max-w-xl mb-10">
            A curated collection of recipes for the modern home cook.
        </p>
        <a href="recipes.php" class="border-b-2 border-white text-white py-2 px-4 text-sm font-bold uppercase tracking-[0.3em] hover:bg-white hover:text-black transition-all border-emerald-600">
            Enter Kitchen
        </a>
    </div>

    <div class="absolute bottom-12 left-1/2 -translate-x-1/2 z-30 flex gap-8">
        <div class="h-[2px] w-12 bg-white/20 overflow-hidden"><div class="progress-line h-full bg-white w-0"></div></div>
        <div class="h-[2px] w-12 bg-white/20 overflow-hidden"><div class="progress-line h-full bg-white w-0"></div></div>
    </div>
</section>

<main class="max-w-6xl mx-auto px-6 py-32">
    <div class="text-center mb-24">
        <span class="text-[10px] font-bold tracking-[0.5em] uppercase text-stone-400">The Latest</span>
        <h2 class="text-4xl font-serif text-stone-900 mt-4">Seasonal Inspiration</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-20 gap-y-32">
        <?php if (!empty($latest_recipes)): ?>
            <?php foreach ($latest_recipes as $index => $r): ?>
                <a href="recipe_detail.php?id=<?php echo $r['recipe_id']; ?>" 
                   class="group block <?php echo ($index % 2 != 0) ? 'md:mt-24' : ''; ?>">
                    
                    <div class="aspect-[4/5] overflow-hidden bg-stone-100 mb-8 relative">
                        <img src="<?php echo htmlspecialchars($r['image_url']); ?>" 
                             class="w-full h-full object-cover grayscale-[20%] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700"
                             alt="<?php echo htmlspecialchars($r['title']); ?>">
                        
                        <div class="absolute top-6 left-6">
                            <span class="bg-white/90 backdrop-blur px-3 py-1 text-[9px] font-black uppercase tracking-widest text-stone-800">
                                <?php echo htmlspecialchars($r['cuisine_type']); ?>
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-serif text-stone-800 group-hover:text-emerald-700 transition-colors">
                                <?php echo htmlspecialchars($r['title']); ?>
                            </h3>
                            <p class="text-stone-400 text-sm mt-2">
                                <?php echo htmlspecialchars($r['cuisine_type']); ?> Level — 
                                <span class="capitalize px-2 py-1 bg-stone-200 text-stone-800 text-xs font-bold">
                                    <?php echo htmlspecialchars($r['difficulty']); ?>
                                </span>
                            </p>
                        </div>
                        <div class="w-10 h-10 border border-stone-200 rounded-full flex items-center justify-center group-hover:bg-emerald-600 group-hover:border-emerald-600 group-hover:text-white transition-all">
                            <span class="text-lg">→</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="col-span-2 text-center text-stone-400 italic">No seasonal recipes found.</p>
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
        slides[current].style.opacity = '0';
        current = (current + 1) % slides.length;
        slides[current].style.opacity = '1';
        animateBar(current);
    }

    animateBar(0);
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