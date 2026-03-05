<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<div class="bg-white min-h-screen pb-32">
    <header class="py-24 px-6 border-b border-stone-100 text-center">
        <span class="text-[10px] font-bold tracking-[0.5em] uppercase text-emerald-600 mb-4 block">Legal & Safety</span>
        <h1 class="text-5xl md:text-6xl font-serif text-stone-900 italic">Privacy Policy</h1>
        <p class="text-stone-400 mt-6 max-w-lg mx-auto font-light leading-relaxed italic">
            Your trust is our most important ingredient. Here is how we protect your data.
        </p>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-20">
        <section class="mb-16">
            <h2 class="text-2xl font-serif text-stone-800 mb-6">Introduction</h2>
            <p class="text-stone-500 font-light leading-relaxed">
                FoodFusion ("we," "our," or "us") စိတ်ဝင်စားစွာ အသုံးပြုပေးတဲ့အတွက် ကျေးဇူးတင်ပါတယ်။ ဤ Privacy Policy သည် သင်၏ ကိုယ်ရေးအချက်အလက်များကို ကျွန်ုပ်တို့ မည်သို့ စုဆောင်း၊ အသုံးပြုပြီး ကာကွယ်ထားသည်ကို ရှင်းလင်းစွာ ဖော်ပြထားခြင်း ဖြစ်ပါသည်။
            </p>
        </section>

        <section class="mb-16 grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="p-10 bg-stone-50 rounded-[2.5rem] border border-stone-100">
                <h3 class="text-lg font-serif text-stone-900 mb-4">What we collect</h3>
                <ul class="text-stone-500 text-sm space-y-3 font-light">
                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-emerald-500 rounded-full"></span> Name & Email Address</li>
                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-emerald-500 rounded-full"></span> User-submitted Recipes</li>
                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-emerald-500 rounded-full"></span> Log Data (IP, Browser type)</li>
                </ul>
            </div>
            <div class="p-10 bg-emerald-900 rounded-[2.5rem] text-emerald-100">
                <h3 class="text-lg font-serif text-white mb-4">Why we collect</h3>
                <ul class="text-sm space-y-3 font-light opacity-80">
                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-emerald-400 rounded-full"></span> To manage your account</li>
                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-emerald-400 rounded-full"></span> To improve our recipes</li>
                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-emerald-400 rounded-full"></span> To send newsletters (Optional)</li>
                </ul>
            </div>
        </section>

        <section class="mb-16 space-y-8">
            <div class="border-l-2 border-emerald-100 pl-8 py-4">
                <h2 class="text-2xl font-serif text-stone-800 mb-4">Content Sharing</h2>
                <p class="text-stone-500 font-light leading-relaxed">
                    သင်တင်လိုက်သော ဟင်းချက်နည်း (Community Submissions) များသည် Public ဖြစ်သောကြောင့် အခြားသူများ ဖတ်ရှုနိုင်ပါသည်။ သို့သော် သင်၏ ကိုယ်ရေးကိုယ်တာ Password နှင့် Email များကို အခြားပြင်ပအဖွဲ့အစည်းများထံ မည်သည့်အခါမျှ ရောင်းချခြင်း သို့မဟုတ် မျှဝေခြင်း ပြုလုပ်မည်မဟုတ်ပါ။
                </p>
            </div>

            <div class="border-l-2 border-emerald-100 pl-8 py-4">
                <h2 class="text-2xl font-serif text-stone-800 mb-4">Cookies & Analytics</h2>
                <p class="text-stone-500 font-light leading-relaxed">
                    Website အသုံးပြုမှု ပိုမိုချောမွေ့စေရန် Cookie နည်းပညာကို အသုံးပြုနိုင်ပါသည်။ သင်သည် သင်၏ Browser Setting မှတစ်ဆင့် Cookies များကို ငြင်းပယ်ပိုင်ခွင့်ရှိပါသည်။
                </p>
            </div>
        </section>

        <section class="mt-24 pt-16 border-t border-stone-100 text-center">
            <h2 class="text-xl font-serif text-stone-900 mb-4">Questions about your data?</h2>
            <p class="text-stone-400 font-light mb-8 italic">အချက်အလက်များနှင့် ပတ်သက်၍ သိလိုသည်များရှိပါက ကျွန်ုပ်တို့ကို ဆက်သွယ်နိုင်ပါသည်။</p>
            <a href="contact.php" class="text-[10px] font-bold uppercase tracking-[0.3em] text-emerald-700 hover:text-emerald-500 transition-colors border-b border-stone-200 pb-2">
                Contact Privacy Team
            </a>
        </section>
    </main>
</div>

<?php include 'includes/footer.php'; ?>