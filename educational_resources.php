<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<div class="bg-stone-50 min-h-screen pt-32 pb-24">
    <header class="max-w-6xl mx-auto px-6 mb-20 text-center">
        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-600 mb-4 block">Powering the Future</span>
        <h1 class="text-5xl md:text-6xl font-serif italic text-stone-900 mb-6">Educational Resources</h1>
        <p class="max-w-2xl mx-auto text-stone-500 font-medium leading-relaxed">
            Access our library of technical guides, system infographics, and expert-led videos to understand how renewable technologies are transforming our global energy landscape.
        </p>
    </header>

    <main class="max-w-6xl mx-auto px-6">
        <section class="mb-24">
            <div class="flex items-center gap-4 mb-10">
                <h2 class="text-xs font-black uppercase tracking-[0.2em] text-stone-400">Technical Video Series</h2>
                <div class="h-[1px] flex-grow bg-stone-200"></div>
            </div>
            
            <div class="group bg-white rounded-[3rem] overflow-hidden border border-stone-100 shadow-sm hover:shadow-2xl transition-all duration-500">
    <div class="relative aspect-video">
        <iframe 
            class="w-full h-full" 
            src="https://www.youtube.com/embed/EImihZVE0sA?si=ig0rPrc2Toy4dsKS" 
            title="YouTube video player" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
            allowfullscreen>
        </iframe>
    </div>
    <div class="p-10">
        <h4 class="text-2xl font-bold text-stone-800 mb-3">Photovoltaic Systems Explained</h4>
        <p class="text-stone-500 leading-relaxed italic">A deep dive into how silicon cells convert sunlight into DC electricity.</p>
    </div>
</div>
        </section>

        <section class="mb-24">
            <div class="flex items-center gap-4 mb-10">
                <h2 class="text-xs font-black uppercase tracking-[0.2em] text-stone-400">Infographics & Whitepapers</h2>
                <div class="h-[1px] flex-grow bg-stone-200"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php 
                $resources = [
                    ['title' => 'Global Energy Mix 2026', 'type' => 'Infographic', 'icon' => '📊', 'color' => 'bg-emerald-50'],
                    ['title' => 'Lithium-Ion Storage Guide', 'type' => 'Technical PDF', 'icon' => '🔋', 'color' => 'bg-blue-50'],
                    ['title' => 'Smart Grid Integration', 'type' => 'Whitepaper', 'icon' => '🌐', 'color' => 'bg-purple-50']
                ];
                foreach ($resources as $res):
                ?>
                <div class="bg-white p-8 rounded-[2.5rem] border border-stone-100 flex flex-col items-start hover:border-emerald-500 transition-all shadow-sm group">
                    <div class="w-14 h-14 <?php echo $res['color']; ?> rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <?php echo $res['icon']; ?>
                    </div>
                    <h5 class="text-lg font-bold text-stone-800 mb-2"><?php echo $res['title']; ?></h5>
                    <p class="text-xs text-stone-400 font-black uppercase tracking-widest mb-8"><?php echo $res['type']; ?></p>
                    <a href="#" class="mt-auto flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 border-b-2 border-emerald-50 hover:border-emerald-600 transition-all">
                        Download Now ↓
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</div>

<?php include 'includes/footer.php'; ?>