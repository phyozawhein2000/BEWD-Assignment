<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<div class="bg-stone-50 min-h-screen pb-20">
    <header class="bg-emerald-900 py-32 text-center text-white relative overflow-hidden">
        <div class="relative z-10 max-w-3xl mx-auto px-6">
            <span class="text-emerald-400 text-[10px] font-black uppercase tracking-[0.4em] mb-6 block animate-fade-in">Our Story</span>
            <h1 class="text-6xl md:text-8xl font-serif italic tracking-tighter mb-8 animate-slide-up">
                Cooking is <span class="text-emerald-400 not-italic font-black">Connection.</span>
            </h1>
            <p class="text-emerald-100/70 text-lg leading-relaxed font-light italic">
                FoodFusion goes beyond recipes. It is a digital sanctuary for those who believe that the best stories are told around a dinner table.
            </p>
        </div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-800 rounded-full blur-3xl opacity-50"></div>
    </header>

    <main class="max-w-6xl mx-auto px-6 -mt-16 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-24">
            <div class="bg-white p-12 rounded-[3rem] shadow-xl shadow-stone-200/50 border border-stone-100">
                <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-4 uppercase tracking-tighter">Our Mission</h3>
                <p class="text-stone-500 leading-relaxed font-medium">
                    To empower every home cook by bridging the gap between <span class="text-emerald-700">diverse culinary traditions</span> and modern convenience, making the art of cooking joyful for everyone.
                </p>
            </div>

            <div class="bg-white p-12 rounded-[3rem] shadow-xl shadow-stone-200/50 border border-stone-100">
                <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-4 uppercase tracking-tighter">Culinary Philosophy</h3>
                <p class="text-stone-500 leading-relaxed font-medium">
                    We believe in <span class="text-emerald-700">"Simplicity through Fusion."</span> By respecting traditional roots while embracing modern global flavors, we create accessible magic.
                </p>
            </div>
        </div>

        <section class="mb-32">
            <h2 class="text-center text-[10px] font-black uppercase text-stone-400 tracking-[0.4em] mb-16 flex items-center justify-center gap-4">
                <span class="w-12 h-px bg-stone-200"></span>
                The Minds Behind FoodFusion
                <span class="w-12 h-px bg-stone-200"></span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-12">
                <div class="text-center group">
                    <div class="aspect-square rounded-[3rem] overflow-hidden mb-6 bg-stone-200 shadow-lg grayscale group-hover:grayscale-0 transition-all duration-700">
                        <img src="assets/img/chef1.jpg" alt="Chef/Founder" class="w-full h-full object-cover">
                    </div>
                    <h4 class="text-xl font-serif italic text-stone-900">Alex Chen</h4>
                    <p class="text-[9px] font-black uppercase tracking-widest text-emerald-600 mt-2">Executive Chef & Founder</p>
                </div>
                <div class="text-center group">
                    <div class="aspect-square rounded-[3rem] overflow-hidden mb-6 bg-stone-200 shadow-lg grayscale group-hover:grayscale-0 transition-all duration-700">
                        <img src="assets/img/chef1.jpg" alt="Creative Lead" class="w-full h-full object-cover">
                    </div>
                    <h4 class="text-xl font-serif italic text-stone-900">Sarah Zaw</h4>
                    <p class="text-[9px] font-black uppercase tracking-widest text-emerald-600 mt-2">Culinary Researcher</p>
                </div>
                <div class="text-center group">
                    <div class="aspect-square rounded-[3rem] overflow-hidden mb-6 bg-stone-200 shadow-lg grayscale group-hover:grayscale-0 transition-all duration-700">
                        <img src="assets/img/chef1.jpg" alt="Tech Lead" class="w-full h-full object-cover">
                    </div>
                    <h4 class="text-xl font-serif italic text-stone-900">David Lee</h4>
                    <p class="text-[9px] font-black uppercase tracking-widest text-emerald-600 mt-2">Lead Developer</p>
                </div>
            </div>
        </section>

        <section class="text-center py-20 bg-white rounded-[4rem] border border-stone-100 shadow-sm mb-24">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-12">
                <div>
                    <p class="text-5xl font-black text-emerald-800 mb-2">100%</p>
                    <p class="text-[9px] font-bold uppercase text-stone-400 tracking-widest">Free Access</p>
                </div>
                <div>
                    <p class="text-5xl font-black text-emerald-800 mb-2">500+</p>
                    <p class="text-[9px] font-bold uppercase text-stone-400 tracking-widest">Shared Recipes</p>
                </div>
                <div>
                    <p class="text-5xl font-black text-emerald-800 mb-2">24/7</p>
                    <p class="text-[9px] font-bold uppercase text-stone-400 tracking-widest">Global Community</p>
                </div>
            </div>
        </section>

        <div class="bg-slate-900 rounded-[4rem] p-12 lg:p-24 text-center relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-4xl md:text-6xl font-serif text-white mb-10 leading-tight">Ready to start your <br> <span class="text-emerald-400 italic font-light">Culinary Journey?</span></h2>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="recipes.php" class="bg-emerald-500 text-white px-12 py-6 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-400 transition-all shadow-xl shadow-emerald-500/20">Browse Recipes</a>
                    <a href="contact.php" class="bg-white/10 text-white px-12 py-6 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-white/20 transition-all border border-white/20 backdrop-blur-md">Get In Touch</a>
                </div>
            </div>
            <div class="absolute top-0 right-0 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-emerald-500/5 rounded-full blur-3xl"></div>
        </div>
    </main>
</div>

<style>
    @keyframes slide-up { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slide-up { animation: slide-up 1s ease-out forwards; }
    .animate-fade-in { animation: opacity 1.5s ease forwards; }
    @keyframes opacity { from { opacity: 0; } to { opacity: 1; } }
</style>

<?php include 'includes/footer.php'; ?>