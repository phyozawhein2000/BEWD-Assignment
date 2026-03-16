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
            သင်ယူမှုဆိုတာ အဆုံးမရှိပါဘူး။ ဟင်းချက်ခြင်းရဲ့ အခြေခံသဘောတရားတွေနဲ့ နည်းစနစ်တွေကို စနစ်တကျ လေ့လာနိုင်ဖို့ ဒီအရင်းအမြစ်တွေကို စုစည်းပေးထားပါတယ်။
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
                    ဓားကို စနစ်တကျ ကိုင်တွယ်နည်းနဲ့ အသီးအရွက်တွေကို ပုံစံအမျိုးမျိုး လှီးဖြတ်နည်း (Julienne, Dice, Mince) အခြေခံများ။
                </p>
                <a href="#" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-emerald-600 border-b-2 border-emerald-100 pb-1 hover:border-emerald-600 transition-all">
                    Explore Guide →
                </a>
            </div>

            <div class="group bg-white rounded-[3rem] p-8 border border-stone-100 shadow-sm hover:shadow-2xl transition-all duration-500">
                <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:scale-110 transition-transform">
                    🌡️
                </div>
                <h3 class="text-2xl font-black text-stone-800 mb-4">Temperature Control</h3>
                <p class="text-stone-500 text-sm leading-relaxed mb-8 italic">
                    အသားအမျိုးမျိုးအတွက် စိတ်ချရတဲ့ အတွင်းပိုင်းအပူချိန်နဲ့ အိုးအပူချိန်ကို ထိန်းညှိနည်း လမ်းညွှန်ချက်များ။
                </p>
                <a href="#" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-emerald-600 border-b-2 border-emerald-100 pb-1 hover:border-emerald-600 transition-all">
                    View Chart →
                </a>
            </div>

            <div class="group bg-white rounded-[3rem] p-8 border border-stone-100 shadow-sm hover:shadow-2xl transition-all duration-500">
                <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:scale-110 transition-transform">
                    🌿
                </div>
                <h3 class="text-2xl font-black text-stone-800 mb-4">Herbs & Spices 101</h3>
                <p class="text-stone-500 text-sm leading-relaxed mb-8 italic">
                    ဟင်းခတ်အမွှေးအကြိုင်တွေကို ဘယ်အချိန်မှာ သုံးရမလဲ? လတ်ဆတ်တာနဲ့ အခြောက် ဘာကွာလဲဆိုတာကို ခွဲခြားလေ့လာပါ။
                </p>
                <a href="#" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-emerald-600 border-b-2 border-emerald-100 pb-1 hover:border-emerald-600 transition-all">
                    Read More →
                </a>
            </div>

        </div>

        <section class="mt-24 bg-emerald-900 rounded-[4rem] p-12 md:p-20 text-center relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-3xl md:text-5xl font-serif italic text-white mb-6">Want the full Kitchen Handbook?</h2>
                <p class="text-emerald-200/70 mb-10 max-w-xl mx-auto font-medium">
                    ကျွန်ုပ်တို့ရဲ့ Culinary Guide PDF ကို အခမဲ့ Download ရယူပြီး အိမ်မှာတင် Professional တစ်ယောက်လို ချက်ပြုတ်လိုက်ပါ။
                </p>
                <button class="bg-white text-emerald-900 px-10 py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[10px] hover:bg-emerald-50 transition-all shadow-xl">
                    Download Free PDF
                </button>
            </div>
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-emerald-800 rounded-full blur-3xl opacity-50"></div>
        </section>
    </main>
</div>

<?php include 'includes/footer.php'; ?>