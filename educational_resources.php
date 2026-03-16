<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<div class="bg-stone-50 min-h-screen pt-32 pb-24">
    <header class="max-w-6xl mx-auto px-6 mb-20">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div class="max-w-2xl">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-600 mb-4 block">Learning Hub</span>
                <h1 class="text-5xl md:text-6xl font-serif italic text-stone-900 mb-6">Educational Resources</h1>
                <p class="text-stone-500 font-medium leading-relaxed italic">
                    ဗဟုသုတဆိုတာ မျှဝေလေ တိုးပွားလေပါပဲ။ ဒီနေရာမှာ ဟင်းချက်နည်း အဆင့်ဆင့် လမ်းညွှန်ချက်တွေနဲ့ ပညာပေး ဗီဒီယိုတွေကို အခမဲ့ လေ့လာနိုင်ပါတယ်။
                </p>
            </div>
            <div class="relative w-full md:w-72">
                <input type="text" placeholder="Search resources..." class="w-full bg-white border border-stone-100 rounded-2xl py-4 pl-12 pr-6 text-xs focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all shadow-sm">
                <span class="absolute left-5 top-1/2 -translate-y-1/2">🔍</span>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6">
        <section class="mb-20">
            <div class="flex items-center gap-4 mb-10">
                <h2 class="text-xs font-black uppercase tracking-[0.2em] text-stone-400">Video Tutorials</h2>
                <div class="h-[1px] flex-grow bg-stone-200"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="group bg-white rounded-[2.5rem] overflow-hidden border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative aspect-video bg-stone-200">
                        <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white text-xl border border-white/30 group-hover:bg-emerald-600 group-hover:border-emerald-600 transition-all shadow-2xl">
                                ▶
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <h4 class="text-xl font-bold text-stone-800 mb-2">The Science of Sautéing</h4>
                        <p class="text-stone-500 text-sm italic font-light">အသီးအရွက်နဲ့ အသားတွေကို အရသာ အရှိဆုံးဖြစ်အောင် ဘယ်လို ဆီသတ်မလဲဆိုတာ သိပ္ပံနည်းကျ လေ့လာပါ။</p>
                    </div>
                </div>

                <div class="group bg-white rounded-[2.5rem] overflow-hidden border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-500">
                    <div class="relative aspect-video bg-stone-200">
                        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white text-xl border border-white/30 group-hover:bg-emerald-600 group-hover:border-emerald-600 transition-all shadow-2xl">
                                ▶
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <h4 class="text-xl font-bold text-stone-800 mb-2">Plating Like a Michelin Chef</h4>
                        <p class="text-stone-500 text-sm italic font-light">ဟင်းပွဲတစ်ခုကို မျက်စိပသာဒဖြစ်အောင် ပြင်ဆင်နည်းနဲ့ အမြင်အာရုံ ဆွဲဆောင်မှုအတတ်ပညာ။</p>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="flex items-center gap-4 mb-10">
                <h2 class="text-xs font-black uppercase tracking-[0.2em] text-stone-400">PDF Guides & E-Books</h2>
                <div class="h-[1px] flex-grow bg-stone-200"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php 
                $guides = [
                    ['title' => 'Flavor Profiling 101', 'type' => 'PDF Guide', 'color' => 'bg-emerald-50'],
                    ['title' => 'Kitchen Safety Handbook', 'type' => 'E-Book', 'color' => 'bg-blue-50'],
                    ['title' => 'Healthy Meal Prep 7-Day', 'type' => 'PDF Chart', 'color' => 'bg-purple-50']
                ];
                foreach ($guides as $guide):
                ?>
                <div class="bg-white p-6 rounded-[2rem] border border-stone-100 flex items-center justify-between hover:border-emerald-200 transition-colors shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 <?php echo $guide['color']; ?> rounded-xl flex items-center justify-center text-xl text-stone-700">
                            📄
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-stone-800"><?php echo $guide['title']; ?></h5>
                            <p class="text-[10px] text-stone-400 font-bold uppercase tracking-widest"><?php echo $guide['type']; ?></p>
                        </div>
                    </div>
                    <button class="p-2 hover:bg-stone-50 rounded-full transition-colors">
                        📥
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</div>

<?php include 'includes/footer.php'; ?>