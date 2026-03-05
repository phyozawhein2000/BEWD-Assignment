<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php';

// 1. URL မှ ID ကို ရယူခြင်း
if (!isset($_GET['id'])) {
    header("Location: recipes.php");
    exit();
}

$id = $_GET['id'];

// 2. Database မှ အချက်အလက် ဆွဲထုတ်ခြင်း
try {
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE recipe_id = ?");
    $stmt->execute([$id]);
    $recipe = $stmt->fetch();

    if (!$recipe) {
        echo "<div class='text-center py-20'><h1>Recipe Not Found!</h1><a href='recipes.php'>Back to Browse</a></div>";
        exit();
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<div class="bg-white min-h-screen pb-20">
    <div class="relative h-[50vh] md:h-[60vh] overflow-hidden">
        <img src="<?php echo $recipe['image_url']; ?>" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white max-w-7xl mx-auto">
            <div class="flex flex-wrap gap-3 mb-4">
                <span class="bg-emerald-600 px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest">
                    <?php echo $recipe['cuisine_type']; ?>
                </span>
                <span class="bg-white/20 backdrop-blur-md px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest">
                    <?php echo $recipe['difficulty']; ?>
                </span>
                <span class="bg-amber-500 px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest">
                    <?php echo $recipe['dietary_preference']; ?>
                </span>
            </div>
            <h1 class="text-4xl md:text-6xl font-black tracking-tighter mb-4 italic">
                <?php echo htmlspecialchars($recipe['title']); ?>
            </h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-12 -mt-10 relative z-10">
        
        <div class="lg:col-span-2 space-y-12">
            <div class="bg-white p-8 md:p-12 rounded-[3rem] shadow-xl border border-stone-100">
                <h3 class="text-2xl font-black text-slate-800 mb-6 flex items-center gap-3">
                    About this Recipe
                </h3>
                <p class="text-stone-600 leading-relaxed text-lg italic mb-8">
                    <?php echo nl2br(htmlspecialchars($recipe['description'])); ?>
                </p>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-stone-50 p-8 rounded-[2.5rem] border border-stone-200">
                <h3 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-widest">Quick Info</h3>
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <span class="text-stone-400 font-bold text-sm uppercase">Cuisine</span>
                        <span class="text-slate-800 font-black italic"><?php echo $recipe['cuisine_type']; ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-stone-400 font-bold text-sm uppercase">Difficulty</span>
                        <span class="text-emerald-600 font-black italic"><?php echo $recipe['difficulty']; ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-stone-400 font-bold text-sm uppercase">Pref</span>
                        <span class="text-slate-800 font-black italic text-xs"><?php echo $recipe['dietary_preference']; ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-stone-400 font-bold text-sm uppercase">Posted</span>
                        <span class="text-slate-800 font-black italic text-xs"><?php echo date('M d, Y', strtotime($recipe['created_at'])); ?></span>
                    </div>
                </div>
            </div>

            <div class="bg-emerald-900 p-8 rounded-[2.5rem] text-white shadow-2xl shadow-emerald-900/40">
                <h3 class="text-xl font-black mb-4 italic">Love this recipe?</h3>
                <p class="text-emerald-200 text-sm mb-6 leading-relaxed opacity-80">Share your creation with us on social media using #FoodFusion.</p>
                <button onclick="window.print()" class="w-full bg-emerald-400 text-emerald-950 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-white transition-all">
                    Print Recipe
                </button>
            </div>
        </div>
    </div>
</div>

<?php //include 'includes/footer.php'; ?>