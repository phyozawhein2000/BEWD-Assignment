<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php';

try {
    // SQL Query ကို Like Count နှင့် Comment Count ပါအောင် ပြင်ဆင်ထားသည်
    $sql = "SELECT c.*, u.first_name, u.last_name, 
            (SELECT COUNT(*) FROM cookbook_likes WHERE submission_id = c.submission_id) as total_likes,
            (SELECT COUNT(*) FROM cookbook_comments WHERE submission_id = c.submission_id) as total_comments
            FROM community_cookbook c 
            JOIN users u ON c.user_id = u.id 
            ORDER BY c.submitted_at DESC";
            
    $stmt = $pdo->query($sql);
    $posts = $stmt->fetchAll();
} catch (PDOException $e) { 
    $posts = []; 
}
?>

<div class="bg-stone-50 min-h-screen pb-20">
    <header class="bg-emerald-800 py-20 text-center text-white relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-4xl md:text-6xl font-black tracking-tighter italic">Community Cookbook</h1>
            <p class="text-emerald-100 opacity-80 mt-4 max-w-xl mx-auto px-6 italic">Every dish tells a story. Read the latest submissions from our food-loving community.</p>
        </div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-emerald-700 rounded-full opacity-20"></div>
    </header>

    <main class="max-w-7xl mx-auto px-6">
        <div class="flex justify-end mb-8">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="submit_cookbook.php" class="bg-amber-400 text-amber-900 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-amber-300 transition-all border-b-4 border-amber-600 active:border-b-0 active:translate-y-1">
                    + Share Your Recipe
                </a>
            <?php else: ?>
                <a href="auth/login.php?msg=Please login to share your recipe" class="bg-stone-200 text-stone-500 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-md hover:bg-stone-300 transition-all border-b-4 border-stone-400">
                    Login to Share Recipe
                </a>
            <?php endif; ?>
        </div>

        <div class="columns-1 md:columns-2 lg:columns-3 gap-8 space-y-8">
            <?php foreach ($posts as $post): ?>
                <div class="block break-inside-avoid group">
                    <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-stone-100 group-hover:shadow-2xl transition-all duration-500 overflow-hidden relative">
                        
                        <a href="view_community_recipe.php?id=<?php echo $post['submission_id']; ?>" class="block">
                            <?php if (!empty($post['image_url']) && $post['image_url'] !== 'default_recipe.jpg'): ?>
                                <div class="relative aspect-video mb-6 overflow-hidden rounded-[1.8rem] -mx-1 -mt-1">
                                    <img src="uploads/cookbook/<?php echo htmlspecialchars($post['image_url']); ?>" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.5s] ease-out" 
                                         alt="<?php echo htmlspecialchars($post['recipe_title']); ?>">
                                    
                                    <div class="absolute top-4 left-4">
                                         <span class="bg-black/30 backdrop-blur-md px-3 py-1 text-[8px] font-black uppercase tracking-widest text-white rounded-full border border-white/20">
                                            <?php echo htmlspecialchars($post['cuisine_type'] ?? 'Recipe'); ?>
                                         </span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <h3 class="text-2xl font-black text-slate-800 mb-3 group-hover:text-emerald-700 transition-colors leading-tight">
                                <?php echo htmlspecialchars($post['recipe_title']); ?>
                            </h3>

                            <div class="text-stone-500 text-sm leading-relaxed mb-6 line-clamp-2 italic font-medium">
                                <?php echo htmlspecialchars(strip_tags($post['recipe_content'])); ?>
                            </div>
                        </a>

                        <div class="flex gap-4 mb-6">
                            <div class="flex items-center gap-1.5">
                                <span class="text-red-500 text-xs">❤️</span>
                                <span class="text-[11px] font-black text-stone-400 uppercase"><?php echo $post['total_likes']; ?></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-emerald-600 text-xs">💬</span>
                                <span class="text-[11px] font-black text-stone-400 uppercase"><?php echo $post['total_comments']; ?></span>
                            </div>
                            <div class="ml-auto">
                                <span class="bg-stone-100 text-stone-500 px-2 py-1 rounded-lg text-[9px] font-black uppercase"><?php echo htmlspecialchars($post['difficulty'] ?? 'Easy'); ?></span>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-stone-50 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center font-black text-emerald-800 border-2 border-white shadow-sm overflow-hidden">
                                     <?php echo strtoupper(substr($post['first_name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black uppercase text-stone-300 tracking-tighter leading-none mb-1">Chef</p>
                                    <p class="text-xs font-bold text-slate-700"><?php echo htmlspecialchars($post['first_name']); ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block text-[10px] font-bold text-stone-300 uppercase"><?php echo date('M d', strtotime($post['submitted_at'])); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>