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

    // 2. Community Posts (Cookbook)
    $post_stmt = $pdo->prepare("SELECT * FROM community_cookbook WHERE user_id = ? ORDER BY submitted_at DESC");
    $post_stmt->execute([$user_id]);
    $my_posts = $post_stmt->fetchAll();

    // 3. Official Recipes (တကယ်လို့ Admin ဆိုရင် သူတင်ထားတာတွေပြမယ်၊ ရိုးရိုး User ဆိုရင် Saved လုပ်ထားတာပြလို့ရတယ်)
    // ဒီနေရာမှာ ဥပမာအနေနဲ့ User တင်ထားတဲ့ Official Recipes တွေကို ဆွဲထုတ်ပြပါမယ်
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
                <h1 class="text-4xl font-serif text-stone-900 italic mb-2"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h1>
                <p class="text-stone-400 font-light italic mb-6"><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-12">
        <div class="flex gap-10 border-b border-stone-200 mb-12">
            <button onclick="switchTab('cookbook')" id="btn-cookbook" class="tab-btn pb-4 text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 border-b-2 border-emerald-600">My Cookbook (<?php echo count($my_posts); ?>)</button>
            <button onclick="switchTab('recipes')" id="btn-recipes" class="tab-btn pb-4 text-[10px] font-black uppercase tracking-[0.2em] text-stone-400 hover:text-stone-900 transition-colors">Official Recipes (<?php echo count($my_recipes); ?>)</button>
        </div>

        <div id="tab-cookbook" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($my_posts as $post): ?>
                    <div class="bg-white p-8 rounded-[2rem] border border-stone-100 shadow-sm hover:shadow-md transition-all">
                        <h4 class="font-serif text-xl italic mb-4 text-stone-800">"<?php echo htmlspecialchars($post['recipe_title']); ?>"</h4>
                        <p class="text-stone-500 text-sm font-light line-clamp-2 mb-6"><?php echo htmlspecialchars($post['recipe_content']); ?></p>
                        <a href="view_community_recipe.php?id=<?php echo $post['submission_id']; ?>" class="text-[9px] font-black uppercase tracking-widest text-emerald-600">Read More →</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="tab-recipes" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($my_recipes as $recipe): ?>
                    <div class="group">
                        <div class="aspect-square bg-stone-200 rounded-[2rem] overflow-hidden mb-4">
                            <img src="<?php echo $recipe['image_url']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                        <h4 class="font-serif text-lg text-stone-800"><?php echo htmlspecialchars($recipe['title']); ?></h4>
                        <p class="text-stone-400 text-xs mt-1 uppercase tracking-widest"><?php echo $recipe['cuisine_type']; ?></p>
                    </div>
                <?php endforeach; ?>
                <?php if(empty($my_recipes)): ?>
                    <p class="text-stone-400 italic font-light">No recipes created yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<script>
function switchTab(tabName) {
    // Hide all content
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
    // Show selected content
    document.getElementById('tab-' + tabName).classList.remove('hidden');
    
    // Update button styles
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('text-emerald-600', 'border-emerald-600');
        btn.classList.add('text-stone-400');
    });
    document.getElementById('btn-' + tabName).classList.add('text-emerald-600', 'border-emerald-600');
    document.getElementById('btn-' + tabName).classList.remove('text-stone-400');
}
</script>

<?php include 'includes/footer.php'; ?>