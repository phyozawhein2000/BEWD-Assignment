<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php';

// ၁။ ဘယ်လို Sort လုပ်မလဲဆိုတာ ဖမ်းယူမယ်
$sort = $_GET['sort'] ?? 'all';

// ၂။ Sort အမျိုးအစားအလိုက် SQL Order ကို သတ်မှတ်မယ်
$orderBy = "c.submitted_at DESC"; // Default က အသစ်ဆုံးအရင်ပြမယ်

if ($sort === 'likes') {
    $orderBy = "c.totalLike DESC";    // Like အများဆုံး
} elseif ($sort === 'comments') {
    $orderBy = "c.totalComment DESC"; // Comment အများဆုံး (Tips & Tricks နေရာမှာ သုံးမှာပါ)
}

try {
    // ၃။ Query ထဲမှာ $orderBy ကို ထည့်သုံးလိုက်ပါပြီ
    $sql = "SELECT c.*, u.first_name, u.last_name
            FROM community_cookbook c 
            JOIN users u ON c.user_id = u.id 
            ORDER BY $orderBy";
            
    $stmt = $pdo->query($sql);
    $posts = $stmt->fetchAll();
} catch (PDOException $e) { 
    $posts = []; 
}
?>

<div class="bg-stone-50 min-h-screen pb-20">
    <header class="bg-emerald-900 py-24 text-center text-white relative overflow-hidden">
        <div class="relative z-10">
            <span class="text-emerald-400 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">FoodFusion Community</span>
            <h1 class="text-5xl md:text-7xl font-serif italic tracking-tighter">Community <span class="not-italic font-black text-emerald-400">Cookbook</span></h1>
            <p class="text-emerald-100 opacity-70 mt-6 max-w-xl mx-auto px-6 font-light text-lg">A shared space for secret family recipes, culinary fails, and kitchen triumphs.</p>
        </div>
        <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-emerald-800 rounded-full blur-3xl opacity-30"></div>
        <div class="absolute -top-20 -left-20 w-60 h-60 bg-emerald-700 rounded-full blur-3xl opacity-20"></div>
    </header>

    <main class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center -mt-10 mb-16 gap-6 relative z-20">
          <div class="bg-white px-8 py-5 rounded-full shadow-xl flex gap-6 border border-stone-100">
                <a href="community.php?sort=all" 
                class="text-[10px] font-black uppercase tracking-widest <?php echo $sort === 'all' ? 'text-emerald-800' : 'text-stone-400'; ?> hover:text-emerald-800 transition-colors">
                All Stories
                </a>
                <a href="community.php?sort=likes" 
                class="text-[10px] font-black uppercase tracking-widest <?php echo $sort === 'likes' ? 'text-emerald-800' : 'text-stone-400'; ?> hover:text-emerald-800 transition-colors">
                Most Liked
                </a>
                <a href="community.php?sort=comments" 
                class="text-[10px] font-black uppercase tracking-widest <?php echo $sort === 'comments' ? 'text-emerald-800' : 'text-stone-400'; ?> hover:text-emerald-800 transition-colors">
                Most Commented
                </a>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="submit_cookbook.php" class="bg-amber-400 text-amber-950 px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-widest shadow-2xl hover:bg-white transition-all transform hover:-translate-y-1">
                    + Share Your Recipe
                </a>
            <?php else: ?>
                <a href="auth/login.php" class="bg-stone-800 text-white px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-widest shadow-2xl hover:bg-emerald-700 transition-all">
                    Login to Join
                </a>
            <?php endif; ?>
        </div>

        <?php if (empty($posts)): ?>
            <div class="text-center py-24 bg-white rounded-[3rem] border border-dashed border-stone-200 shadow-inner">
                <p class="text-stone-400 italic font-serif text-xl">The cookbook is empty. Be the first to share a recipe!</p>
            </div>
        <?php else: ?>
            <div class="columns-1 md:columns-2 lg:columns-3 gap-10 space-y-10">
                <?php foreach ($posts as $post): ?>
                    <div class="break-inside-avoid group">
                        <div class="bg-white p-7 rounded-[3rem] shadow-sm border border-stone-100 group-hover:shadow-2xl transition-all duration-700 relative flex flex-col">
                            
                            <a href="view_community_recipe.php?id=<?php echo $post['submission_id']; ?>" class="block overflow-hidden rounded-[2rem] mb-6 relative">
                                <?php 
                                    $img = (!empty($post['image_url']) && $post['image_url'] !== 'default_recipe.jpg') 
                                           ? "uploads/cookbook/" . htmlspecialchars($post['image_url']) 
                                           : "assets/img/placeholder.jpg";
                                ?>
                                <img src="<?php echo $img; ?>" 
                                     class="w-full h-auto object-cover group-hover:scale-110 transition-transform duration-[2s] ease-out shadow-inner" 
                                     alt="Recipe">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </a>

                            <div class="px-2">
                                <span class="text-emerald-600 text-[9px] font-black uppercase tracking-[0.3em] mb-3 block">
                                    <?php echo htmlspecialchars($post['cuisine_type'] ?? 'Culinary Tip'); ?>
                                </span>

                                <h3 class="text-2xl font-serif italic text-slate-900 mb-4 leading-tight group-hover:text-emerald-800 transition-colors">
                                    <?php echo htmlspecialchars($post['recipe_title']); ?>
                                </h3>

                                <p class="text-stone-500 text-sm leading-relaxed mb-8 line-clamp-3 font-light italic">
                                    "<?php echo htmlspecialchars(strip_tags($post['recipe_content'])); ?>"
                                </p>

                                <div class="flex items-center gap-6 mb-8 border-y border-stone-50 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg">❤️</span>
                                        <span class="text-xs font-black text-stone-400">
                                            <?php echo $post['totalLike'];  ?>
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg">💬</span>
                                        <span class="text-xs font-black text-stone-400">
                                            <?php echo $post['totalComment']; ?>
                                        </span>
                                    </div>
                                    <span class="ml-auto text-[9px] font-black text-stone-300 uppercase tracking-widest border border-stone-100 px-3 py-1 rounded-full">
                                        <?php echo $post['difficulty'] ?? 'Easy'; ?>
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-stone-900 rounded-full flex items-center justify-center font-black text-white text-xs border-4 border-stone-50 shadow-sm">
                                             <?php echo strtoupper(substr($post['first_name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <p class="text-[8px] font-black uppercase text-stone-300 tracking-widest leading-none mb-1">Contributor</p>
                                            <p class="text-xs font-bold text-slate-800 italic"><?php echo htmlspecialchars($post['first_name'] . ' ' . $post['last_name']); ?></p>
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-black text-stone-300 uppercase"><?php echo date('M d', strtotime($post['submitted_at'])); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>