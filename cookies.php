<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<div class="bg-white min-h-screen pb-32">
    <header class="py-24 px-6 border-b border-stone-100 text-center">
        <span class="text-[10px] font-bold tracking-[0.5em] uppercase text-emerald-600 mb-4 block">Transparency</span>
        <h1 class="text-5xl md:text-6xl font-serif text-stone-900 italic">Cookie Policy</h1>
        <p class="text-stone-400 mt-6 max-w-lg mx-auto font-light leading-relaxed italic">
            How we use small bits of data to improve your culinary experience.
        </p>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-20">
        <section class="mb-20">
            <h2 class="text-2xl font-serif text-stone-800 mb-6">What are Cookies?</h2>
            <p class="text-stone-500 font-light leading-relaxed">
                Cookies ဆိုသည်မှာ သင် Website အသုံးပြုနေစဉ် သင်၏ Browser (Computer သို့မဟုတ် Mobile) ထဲတွင် သိမ်းဆည်းထားသော စာသားဖိုင်အသေးစားလေးများ ဖြစ်ပါသည်။ ၎င်းတို့သည် Website ကို ပိုမိုကောင်းမွန်စွာ အလုပ်လုပ်စေရန်နှင့် သင့်အတွက် ပိုမိုအဆင်ပြေစေရန် ကူညီပေးပါသည်။
            </p>
        </section>

        <section class="mb-20">
            <h2 class="text-2xl font-serif text-stone-800 mb-10">How We Use Cookies</h2>
            
            <div class="space-y-8">
                <div class="flex flex-col md:flex-row gap-6 p-8 bg-stone-50 rounded-[2rem] border border-stone-100">
                    <div class="w-12 h-12 bg-emerald-800 rounded-2xl shrink-0 flex items-center justify-center shadow-lg shadow-emerald-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-serif text-stone-900 mb-2">Essential Cookies</h4>
                        <p class="text-stone-500 text-sm font-light leading-relaxed">
                            Website ထဲသို့ Login ဝင်ရောက်ခြင်းနှင့် လုံခြုံရေးဆိုင်ရာ ကိစ္စရပ်များအတွက် မရှိမဖြစ်လိုအပ်သော Cookie များ ဖြစ်ပါသည်။ ၎င်းတို့မရှိပါက Website ၏ အချို့သော ဝန်ဆောင်မှုများ အလုပ်လုပ်မည် မဟုတ်ပါ။
                        </p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-6 p-8 bg-white rounded-[2rem] border border-stone-100">
                    <div class="w-12 h-12 bg-stone-100 rounded-2xl shrink-0 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-serif text-stone-900 mb-2">Performance & Analytics</h4>
                        <p class="text-stone-500 text-sm font-light leading-relaxed">
                            User များ Website ကို မည်သို့ အသုံးပြုသည်ကို လေ့လာရန် (ဥပမာ- ဘယ်စာမျက်နှာကို အများဆုံးဖတ်သလဲ) ဆိုသည်ကို သိရှိစေရန် အသုံးပြုပါသည်။ ၎င်းသည် Website ကို ပိုမိုတိုးတက်အောင် ပြုလုပ်ရာတွင် အထောက်အကူပြုပါသည်။
                        </p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-6 p-8 bg-stone-50 rounded-[2rem] border border-stone-100">
                    <div class="w-12 h-12 bg-amber-100 rounded-2xl shrink-0 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-serif text-stone-900 mb-2">Functional Cookies</h4>
                        <p class="text-stone-500 text-sm font-light leading-relaxed">
                            သင်နှစ်သက်သော Setting များ (ဥပမာ- Language သို့မဟုတ် Dark Mode) ကို မှတ်သားထားရန် အသုံးပြုပါသည်။
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-20">
            <h2 class="text-2xl font-serif text-stone-800 mb-6">Managing Your Choice</h2>
            <p class="text-stone-500 font-light leading-relaxed mb-8">
                သင်သည် သင်၏ Browser Setting ထဲတွင် Cookies များကို ပိတ်ထားရန် သို့မဟုတ် ဖျက်ပစ်ရန် ရွေးချယ်နိုင်ပါသည်။ သို့သော် Cookies များကို ပိတ်ထားပါက Website ၏ အချို့သော အစိတ်အပိုင်းများ ကောင်းမွန်စွာ အလုပ်မလုပ်နိုင်သည်ကို သတိပြုစေလိုပါသည်။
            </p>
            <div class="flex gap-4">
                <a href="#" class="text-[10px] font-bold uppercase tracking-widest text-stone-400 hover:text-stone-900 transition-colors border-b border-stone-200 pb-1">Chrome Settings</a>
                <a href="#" class="text-[10px] font-bold uppercase tracking-widest text-stone-400 hover:text-stone-900 transition-colors border-b border-stone-200 pb-1">Safari Settings</a>
            </div>
        </section>

        <footer class="mt-24 pt-10 border-t border-stone-100 italic text-[11px] text-stone-400 text-center">
            Last Updated: March 2024
        </footer>
    </main>
</div>

<?php include 'includes/footer.php'; ?>