<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // 1. User Info
    $user_stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $user_stmt->execute([$user_id]);
    $user = $user_stmt->fetch();

    // 2. Community Cookbook Posts
    $post_stmt = $pdo->prepare("SELECT * FROM community_cookbook WHERE user_id = ? ORDER BY submitted_at DESC");
    $post_stmt->execute([$user_id]);
    $my_posts = $post_stmt->fetchAll();

    // 3. Personal Recipe Collection
    $recipe_stmt = $pdo->prepare("SELECT * FROM recipes WHERE user_id = ? ORDER BY created_at DESC");
    $recipe_stmt->execute([$user_id]);
    $my_recipes = $recipe_stmt->fetchAll();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<div class="bg-stone-50 min-h-screen pb-24">
    <header class="bg-white border-b border-stone-100 pt-32 pb-16">
        <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-center gap-10">
            <div class="w-32 h-32 bg-emerald-900 rounded-[2.5rem] flex items-center justify-center text-white text-4xl font-black shadow-2xl shadow-emerald-900/20">
                <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
            </div>
            <div class="flex-grow text-center md:text-left">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-600 mb-2 block">Welcome Back</span>
                <h1 class="text-4xl font-serif text-stone-900 italic mb-2">
                    <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                </h1>
                <p class="text-stone-400 font-light italic"><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <div>
                <a href="edit_profile.php" class="px-8 py-4 bg-stone-900 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-emerald-800 transition-all shadow-xl">
                    Edit Profile
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-12">
        <div class="flex gap-10 border-b border-stone-200 mb-12">
            <button onclick="switchTab('cookbook')" id="btn-cookbook" class="tab-btn pb-4 text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 border-b-2 border-emerald-600">
                My Cookbook (<?php echo count($my_posts); ?>)
            </button>
            <!-- <button onclick="switchTab('recipes')" id="btn-recipes" class="tab-btn pb-4 text-[10px] font-black uppercase tracking-[0.2em] text-stone-400 hover:text-stone-900 transition-colors">
                Personal Recipes (<?php echo count($my_recipes); ?>)
            </button> -->
        </div>

        <div id="tab-cookbook" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($my_posts as $post): ?>
                    <div class="group bg-white rounded-[2.5rem] border border-stone-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden flex flex-col">
                        <div class="relative aspect-[4/3] overflow-hidden bg-stone-100">
                            <?php if (!empty($post['image_url']) && $post['image_url'] !== 'default_recipe.jpg'): ?>
                                <img src="uploads/cookbook/<?php echo htmlspecialchars($post['image_url']); ?>" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                                     alt="Recipe image">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-stone-300 italic text-[10px] uppercase font-black tracking-widest">
                                    No Image Provided
                                </div>
                            <?php endif; ?>
                            
                            <div class="absolute top-4 right-4">
                                <span class="bg-black/20 backdrop-blur-md text-[8px] font-black text-white px-3 py-1 rounded-full uppercase tracking-widest">
                                    <?php echo date('M d', strtotime($post['submitted_at'])); ?>
                                </span>
                            </div>
                        </div>

                        <div class="p-8 flex-grow">
                            <h4 class="font-serif text-xl italic mb-3 text-stone-800 leading-tight">
                                "<?php echo htmlspecialchars($post['recipe_title']); ?>"
                            </h4>
                            <p class="text-stone-500 text-sm font-light line-clamp-3 mb-6 italic leading-relaxed">
                                <?php echo htmlspecialchars($post['recipe_content']); ?>
                            </p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-stone-50">
                                <a href="view_community_recipe.php?id=<?php echo $post['submission_id']; ?>" 
                                   class="text-[9px] font-black uppercase tracking-widest text-emerald-600 hover:text-emerald-800 transition-colors">
                                    View Entry →
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if(empty($my_posts)): ?>
                    <div class="col-span-full py-24 text-center bg-white rounded-[3rem] border-2 border-dashed border-stone-100">
                        <p class="text-stone-400 italic font-light tracking-wide mb-6">You haven't shared any stories in the cookbook yet.</p>
                        <a href="submit_cookbook.php" class="bg-emerald-50 text-emerald-600 px-8 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all">
                            Share Your First Recipe
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div id="tab-recipes" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($my_recipes as $recipe): ?>
                    <div class="group bg-white p-4 rounded-[2.5rem] border border-stone-100 hover:shadow-lg transition-all">
                        <div class="aspect-square bg-stone-200 rounded-[2rem] overflow-hidden mb-6">
                            <img src="<?php echo htmlspecialchars($recipe['image_url']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                        <h4 class="font-serif text-lg text-stone-800 px-2"><?php echo htmlspecialchars($recipe['title']); ?></h4>
                        <p class="text-stone-400 text-[10px] mt-1 px-2 uppercase tracking-widest font-black"><?php echo htmlspecialchars($recipe['cuisine_type']); ?></p>
                    </div>
                <?php endforeach; ?>
                
                <?php if(empty($my_recipes)): ?>
                    <div class="col-span-full py-12 text-center">
                        <p class="text-stone-400 italic font-light">No personal recipes created yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<script>
function switchTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
    document.getElementById('tab-' + tabName).classList.remove('hidden');
    
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('text-emerald-600', 'border-emerald-600');
        btn.classList.add('text-stone-400');
    });
    document.getElementById('btn-' + tabName).classList.add('text-emerald-600', 'border-emerald-600');
}
</script>