<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php';

if (!isset($_GET['id'])) {
    header("Location: community.php");
    exit();
}

$submission_id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT c.*, u.first_name, u.last_name, u.email 
                          FROM community_cookbook c 
                          JOIN users u ON c.user_id = u.id 
                          WHERE c.submission_id = ?");
    $stmt->execute([$submission_id]);
    $recipe = $stmt->fetch();

    if (!$recipe) {
        echo "<div class='py-40 text-center font-serif italic text-stone-400'>Recipe not found.</div>";
        exit();
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<div class="bg-stone-50 min-h-screen pb-24">
    <div class="relative h-[60vh] w-full overflow-hidden bg-stone-900">
        <?php if (!empty($recipe['image_url']) && $recipe['image_url'] !== 'default_recipe.jpg'): ?>
            <img src="uploads/cookbook/<?php echo htmlspecialchars($recipe['image_url']); ?>" 
                 class="w-full h-full object-cover opacity-80" alt="Recipe Hero">
        <?php else: ?>
            <div class="w-full h-full flex items-center justify-center bg-emerald-900">
                <span class="text-white/20 font-serif italic text-6xl">Simply Delicious</span>
            </div>
        <?php endif; ?>
        
        <div class="absolute inset-0 bg-gradient-to-t from-stone-50 via-transparent to-transparent"></div>
    </div>

    <article class="max-w-4xl mx-auto px-6 -mt-32 relative z-10">
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-stone-200/50 p-8 md:p-16 border border-stone-100">
            
            <div class="flex items-center gap-3 mb-8">
                <span class="bg-emerald-100 text-emerald-700 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">
                    Community Recipe
                </span>
                <span class="h-[1px] w-8 bg-stone-200"></span>
                <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">
                    <?php echo date('F d, Y', strtotime($recipe['submitted_at'])); ?>
                </span>
            </div>

            <h1 class="text-4xl md:text-6xl font-serif italic text-stone-900 leading-tight mb-10">
                <?php echo htmlspecialchars($recipe['recipe_title']); ?>
            </h1>

            <div class="flex items-center gap-5 p-6 bg-stone-50 rounded-3xl mb-12 border border-stone-100">
                <div class="w-14 h-14 bg-emerald-800 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-lg">
                    <?php echo strtoupper(substr($recipe['first_name'], 0, 1)); ?>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase text-stone-400 tracking-tighter mb-1">Shared by</p>
                    <p class="text-lg font-bold text-stone-900 leading-none">
                        <?php echo htmlspecialchars($recipe['first_name'] . ' ' . $recipe['last_name']); ?>
                    </p>
                </div>
            </div>

            <div class="prose prose-stone max-w-none">
                <h3 class="text-xs font-black uppercase text-emerald-600 tracking-[0.3em] mb-8 flex items-center gap-4">
                    The Kitchen Story <span class="h-[1px] flex-grow bg-emerald-100"></span>
                </h3>
                <div class="text-stone-700 text-lg md:text-xl leading-relaxed font-light italic whitespace-pre-line">
                    <?php echo nl2br(htmlspecialchars($recipe['recipe_content'])); ?>
                </div>
            </div>

            <div class="mt-20 pt-10 border-t border-stone-100 flex flex-col md:flex-row items-center justify-between gap-6">
                <a href="community.php" class="text-stone-400 hover:text-emerald-700 transition-colors font-bold text-xs uppercase tracking-widest flex items-center gap-2">
                    ← Back to Cookbook
                </a>
                <button onclick="window.print()" class="px-8 py-3 bg-stone-900 text-white rounded-full font-black text-[10px] uppercase tracking-widest hover:bg-emerald-700 transition-all">
                    Print Recipe
                </button>
            </div>
        </div>
    </article>
</div>