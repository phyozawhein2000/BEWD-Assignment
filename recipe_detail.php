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
        echo "<div class='text-center py-40 font-serif'><h1 class='text-4xl italic'>Recipe Not Found!</h1><a href='recipes.php' class='text-emerald-600 underline'>Back to Browse</a></div>";
        exit();
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<div class="bg-white min-h-screen pb-20">
    <div class="relative h-[60vh] md:h-[70vh] overflow-hidden">
        <img src="<?php echo htmlspecialchars($recipe['image_url']); ?>" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 right-0 p-8 md:p-20 text-white max-w-7xl mx-auto">
            <div class="flex flex-wrap gap-3 mb-6">
                <span class="bg-emerald-600 px-5 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-lg">
                    <?php echo $recipe['cuisine_type']; ?>
                </span>
                <span class="bg-white/20 backdrop-blur-md px-5 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em]">
                    <?php echo $recipe['difficulty']; ?>
                </span>
            </div>
            <h1 class="text-5xl md:text-8xl font-serif italic tracking-tighter mb-4 leading-[0.9]">
                <?php echo htmlspecialchars($recipe['title']); ?>
            </h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-12 -mt-10 relative z-10">
    
    <div class="lg:col-span-2">
        <div class="bg-white p-8 md:p-12 rounded-[3rem] shadow-xl border border-stone-100">
            <h3 class="text-3xl font-serif italic text-stone-900 mb-8 flex items-center gap-4">
                Recipe Guide
                <span class="h-px flex-grow bg-stone-100"></span>
            </h3>
            
            <div class="text-stone-600 leading-relaxed text-lg font-light">
                <?php 
                    if (!empty($recipe['description'])) {
                        // nl2br သုံးထားလို့ Enter ခေါက်ထားသမျှ စာကြောင်းဆင်းပေးမှာပါ
                        echo nl2br(htmlspecialchars($recipe['description'])); 
                    } else {
                        echo "<p class='italic text-stone-400'>No details provided for this recipe.</p>";
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <div class="bg-stone-50 p-8 rounded-[2.5rem] border border-stone-200 shadow-sm">
            <h3 class="text-[10px] font-black text-stone-400 mb-8 uppercase tracking-[0.4em]">Recipe Overview</h3>
            <div class="space-y-6">
                <div class="flex items-center justify-between py-2 border-b border-stone-200/50">
                    <span class="text-stone-400 font-bold text-[10px] uppercase">Cuisine</span>
                    <span class="text-slate-800 font-black italic"><?php echo htmlspecialchars($recipe['cuisine_type']); ?></span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-stone-200/50">
                    <span class="text-stone-400 font-bold text-[10px] uppercase">Level</span>
                    <span class="text-emerald-600 font-black italic"><?php echo $recipe['difficulty']; ?></span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-stone-200/50">
                    <span class="text-stone-400 font-bold text-[10px] uppercase">Dietary</span>
                    <span class="text-slate-800 font-black italic text-xs"><?php echo htmlspecialchars($recipe['dietary_preference']); ?></span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-stone-400 font-bold text-[10px] uppercase">Created</span>
                    <span class="text-slate-800 font-medium text-xs"><?php echo date('M d, Y', strtotime($recipe['created_at'])); ?></span>
                </div>
            </div>
        </div>

        <button onclick="window.print()" class="w-full bg-emerald-800 text-white py-5 rounded-[2rem] font-black text-[10px] uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-xl active:scale-95">
            Print This Recipe
        </button>
    </div>
</div>
</div>

<style>
    @media print {
        .bg-white, .bg-stone-50 { background: white !important; }
        .lg\:col-span-2 { width: 100% !important; }
        header, .navbar, .bg-emerald-900, button { display: none !important; }
        img { height: 300px !important; }
    }
</style>

<?php include 'includes/footer.php'; ?>