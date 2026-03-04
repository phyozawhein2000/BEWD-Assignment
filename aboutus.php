<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<div class="bg-stone-50 min-h-screen pb-20">
    <header class="bg-emerald-900 py-24 text-center text-white relative overflow-hidden">
        <div class="relative z-10 max-w-3xl mx-auto px-6">
            <span class="text-emerald-400 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">Our Story</span>
            <h1 class="text-5xl md:text-7xl font-black tracking-tighter italic mb-6">Cooking is <span class="text-emerald-400">Connection.</span></h1>
            <p class="text-emerald-100/70 text-lg leading-relaxed font-medium">
                FoodFusion ဆိုတာ ဟင်းချက်နည်းတွေ စုစည်းထားရုံတင်မကဘဲ အစားအသောက် ချစ်မြတ်နိုးသူတွေရဲ့ ရင်ခုန်သံချင်း ထိတွေ့နိုင်မယ့် နေရာတစ်ခု ဖြစ်ပါတယ်။
            </p>
        </div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-800 rounded-full blur-3xl opacity-50"></div>
    </header>

    <main class="max-w-6xl mx-auto px-6 -mt-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
            <div class="bg-white p-12 rounded-[3rem] shadow-xl shadow-stone-200/50 border border-stone-100">
                <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-4">Our Mission</h3>
                <p class="text-stone-500 leading-relaxed italic font-medium">
                    ကျွန်ုပ်တို့ရဲ့ ရည်မှန်းချက်ကတော့ မြန်မာနိုင်ငံတဝှမ်းက ရိုးရာဟင်းချက်နည်းတွေနဲ့ ကမ္ဘာတစ်ဝှမ်းက အရသာအသစ်တွေကို တစ်နေရာတည်းမှာ လွယ်လွယ်ကူကူ လေ့လာနိုင်ဖို့ ဖြစ်ပါတယ်။
                </p>
            </div>

            <div class="bg-white p-12 rounded-[3rem] shadow-xl shadow-stone-200/50 border border-stone-100">
                <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-4">Community Focused</h3>
                <p class="text-stone-500 leading-relaxed italic font-medium">
                    အစားအသောက်ဆိုတာ မျှဝေခြင်း ဖြစ်တဲ့အတွက် လူတိုင်း မိမိတို့ရဲ့ ဟင်းချက်နည်း လျှို့ဝှက်ချက်တွေကို လွတ်လပ်စွာ မျှဝေနိုင်မယ့် Community အဝန်းအဝိုင်းတစ်ခုကို တည်ဆောက်ထားပါတယ်။
                </p>
            </div>
        </div>

        <section class="text-center">
            <h2 class="text-xs font-black uppercase text-stone-400 tracking-[0.4em] mb-12 flex items-center justify-center gap-4">
                <span class="w-12 h-px bg-stone-200"></span>
                Why Choose Us
                <span class="w-12 h-px bg-stone-200"></span>
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-12">
                <div>
                    <p class="text-4xl font-black text-emerald-800 mb-2">100%</p>
                    <p class="text-xs font-bold uppercase text-stone-400 tracking-widest">Free Access</p>
                </div>
                <div>
                    <p class="text-4xl font-black text-emerald-800 mb-2">500+</p>
                    <p class="text-xs font-bold uppercase text-stone-400 tracking-widest">Shared Recipes</p>
                </div>
                <div>
                    <p class="text-4xl font-black text-emerald-800 mb-2">24/7</p>
                    <p class="text-xs font-bold uppercase text-stone-400 tracking-widest">Global Support</p>
                </div>
            </div>
        </section>

        <div class="mt-24 bg-slate-900 rounded-[4rem] p-12 lg:p-20 text-center relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-8">Ready to start your <br> <span class="text-emerald-400 italic">Culinary Journey?</span></h2>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="index.php" class="bg-emerald-500 text-white px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-400 transition-all shadow-lg shadow-emerald-500/20">Browse Recipes</a>
                    <a href="contact.php" class="bg-white/10 text-white px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-white/20 transition-all border border-white/20">Get In Touch</a>
                </div>
            </div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>