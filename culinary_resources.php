<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<div class="bg-stone-50 min-h-screen pt-32 pb-24">
    <header class="max-w-6xl mx-auto px-6 mb-16 text-center">
        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-600 mb-4 block">Master the Art</span>
        <h1 class="text-5xl md:text-6xl font-serif italic text-stone-900 mb-6">Culinary Resources</h1>
        <p class="max-w-2xl mx-auto text-stone-500 font-medium leading-relaxed">
            Learning is a journey that never ends. We have curated these essential resources to help you master fundamental techniques and kitchen secrets.
        </p>
    </header>

    <main class="max-w-6xl mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        
        <div class="group bg-white rounded-[3rem] p-8 border border-stone-100 shadow-sm hover:shadow-2xl transition-all duration-500">
            <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:scale-110 transition-transform">
                🔪
            </div>
            <h3 class="text-2xl font-black text-stone-800 mb-4">Essential Knife Skills</h3>
            <p class="text-stone-500 text-sm leading-relaxed mb-8 italic">
                Master the fundamental grips and precise cutting styles like Julienne, Dice, and Mince for professional prep work.
            </p>
            <a href="#" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-emerald-600 border-b-2 border-emerald-100 pb-1 hover:border-emerald-600 transition-all">
                Explore Guide →
            </a>
        </div>

        <div class="group bg-white rounded-[3rem] p-8 border border-stone-100 shadow-sm hover:shadow-2xl transition-all duration-500">
            <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:scale-110 transition-transform">
                🌡️
            </div>
            <h3 class="text-2xl font-black text-stone-800 mb-4">Heat Management</h3>
            <p class="text-stone-500 text-sm leading-relaxed mb-8 italic">
                A complete guide to internal meat temperatures and pan searing levels to ensure perfectly cooked meals every time.
            </p>
            <a href="#" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-emerald-600 border-b-2 border-emerald-100 pb-1 hover:border-emerald-600 transition-all">
                View Charts →
            </a>
        </div>

        <div class="group bg-white rounded-[3rem] p-8 border border-stone-100 shadow-sm hover:shadow-2xl transition-all duration-500">
            <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:scale-110 transition-transform">
                🌿
            </div>
            <h3 class="text-2xl font-black text-stone-800 mb-4">The Flavor Bible</h3>
            <p class="text-stone-500 text-sm leading-relaxed mb-8 italic">
                Discover the art of balancing fresh herbs and dried spices to elevate your dishes with complex, aromatic layers.
            </p>
            <a href="#" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-emerald-600 border-b-2 border-emerald-100 pb-1 hover:border-emerald-600 transition-all">
                Read More →
            </a>
        </div>

    </div> <section class="mt-24 bg-emerald-900 rounded-[4rem] p-12 md:p-20 text-center relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-3xl md:text-5xl font-serif italic text-white mb-6">Need the Kitchen Handbook?</h2>
            <p class="text-emerald-200/70 mb-10 max-w-xl mx-auto font-medium">
                Download our comprehensive Culinary Guide PDF for free and start cooking like a professional chef today.
            </p>
            <a href="assets/docs/handbook.pdf" download class="bg-white text-emerald-900 px-10 py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[10px] hover:bg-emerald-50 transition-all shadow-xl inline-block">
                Download Free PDF
            </a>
        </div>
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-emerald-800 rounded-full blur-3xl opacity-40"></div>
    </section>
</main>
</div>
<?php include 'includes/footer.php'; ?>