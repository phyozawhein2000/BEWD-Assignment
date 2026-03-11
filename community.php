<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php';

try {
    $stmt = $pdo->query("SELECT c.*, u.first_name, u.last_name FROM community_cookbook c JOIN users u ON c.user_id = u.id ORDER BY c.submitted_at DESC");
    $posts = $stmt->fetchAll();
} catch (PDOException $e) { $posts = []; }
?>

<div class="bg-stone-50 min-h-screen pb-20">
    <header class="bg-emerald-800 py-20 text-center text-white">
        <h1 class="text-4xl md:text-6xl font-black tracking-tighter italic">Community Cookbook</h1>
        <p class="text-emerald-100 opacity-80 mt-4 max-w-xl mx-auto px-6">Every dish tells a story. Read the latest submissions from our food-loving community.</p>
    </header>

    <main class="max-w-7xl mx-auto px-6 -mt-10">
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
        <a href="view_community_recipe.php?id=<?php echo $post['submission_id']; ?>" class="block break-inside-avoid group">
            <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-stone-100 group-hover:shadow-2xl transition-all duration-500 overflow-hidden">
                
                <?php if (!empty($post['image_url']) && $post['image_url'] !== 'default_recipe.jpg'): ?>
                    <div class="relative aspect-video mb-6 overflow-hidden rounded-[1.8rem] -mx-1 -mt-1">
                        <img src="uploads/cookbook/<?php echo htmlspecialchars($post['image_url']); ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.5s] ease-out" 
                             alt="<?php echo htmlspecialchars($post['recipe_title']); ?>">
                        
                        <div class="absolute top-4 left-4">
                             <span class="bg-white/20 backdrop-blur-md border border-white/30 px-3 py-1 text-[8px] font-black uppercase tracking-widest text-white rounded-full">
                                Community Recipe
                             </span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <span class="text-[10px] font-black uppercase text-emerald-600 tracking-widest">Recipe Post</span>
                    </div>
                <?php endif; ?>

                <h3 class="text-2xl font-black text-slate-800 mb-4 group-hover:text-emerald-700 transition-colors leading-tight">
                    <?php echo htmlspecialchars($post['recipe_title']); ?>
                </h3>

                <div class="text-stone-500 text-sm leading-relaxed mb-8 line-clamp-3 italic font-medium">
                    <?php echo nl2br(htmlspecialchars($post['recipe_content'])); ?>
                </div>

                <div class="pt-6 border-t border-stone-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center font-black text-emerald-800 border-2 border-white shadow-sm overflow-hidden">
                             <?php echo strtoupper(substr($post['first_name'], 0, 1)); ?>
                        </div>
                        <div>
                            <p class="text-[9px] font-black uppercase text-stone-300 tracking-tighter leading-none mb-1">Chef</p>
                            <p class="text-xs font-bold text-slate-700"><?php echo htmlspecialchars($post['first_name'] . ' ' . $post['last_name']); ?></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block text-[10px] font-bold text-stone-300 uppercase"><?php echo date('M d', strtotime($post['submitted_at'])); ?></span>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>
    </main>
</div>