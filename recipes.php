<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php'; 

// 1. Search & Filter Logic
$search = $_GET['search'] ?? '';
$cuisine = $_GET['cuisine'] ?? 'All';
$difficulty = $_GET['difficulty'] ?? 'All';
$dietary = $_GET['dietary'] ?? 'All'; // Dietary Preference အတွက် အသစ်

try {
    // Base Query
    $sql = "SELECT * FROM recipes WHERE title LIKE :search";
    $params = [':search' => "%$search%"];

    // Cuisine Filter
    if ($cuisine !== 'All') {
        $sql .= " AND cuisine_type = :cuisine";
        $params[':cuisine'] = $cuisine;
    }

    // Difficulty Filter
    if ($difficulty !== 'All') {
        $sql .= " AND difficulty = :difficulty";
        $params[':difficulty'] = $difficulty;
    }

    // Dietary Filter (Requirement အရ အသစ်ထည့်သွင်းခြင်း)
    if ($dietary !== 'All') {
        $sql .= " AND dietary_preference = :dietary";
        $params[':dietary'] = $dietary;
    }

    $sql .= " ORDER BY created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $recipes = $stmt->fetchAll();
} catch (PDOException $e) {
    $recipes = [];
    $error = $e->getMessage();
}
?>

<div class="bg-stone-50 min-h-screen pb-20">
    <header class="bg-emerald-900 py-24 text-center text-white relative overflow-hidden">
        <div class="relative z-10">
            <span class="text-emerald-400 text-[10px] font-black uppercase tracking-[0.4em] mb-4 block">The Collection</span>
            <h1 class="text-5xl md:text-7xl font-serif italic tracking-tighter mb-6">World <span class="text-emerald-400 not-italic font-black">Flavors.</span></h1>
            <p class="text-emerald-100 opacity-70 max-w-2xl mx-auto px-6 font-light text-lg">
                Explore a curated gallery of global cuisines, tailored to your lifestyle and skill level.
            </p>
        </div>
        <div class="absolute -top-20 -left-20 w-80 h-80 bg-emerald-800 rounded-full blur-3xl opacity-30"></div>
    </header>

    <section class="max-w-7xl mx-auto px-6 -mt-12 relative z-20">
        <div class="bg-white p-6 md:p-10 rounded-[3rem] shadow-2xl border border-stone-100">
            <form action="recipes.php" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-6">
                
                <div class="md:col-span-3 relative">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Search recipes..." 
                           class="w-full pl-12 pr-4 py-4 rounded-2xl bg-stone-50 border-stone-100 text-sm focus:ring-2 focus:ring-emerald-500 transition-all font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-4 top-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <div class="md:col-span-2">
                    <select name="cuisine" onchange="this.form.submit()" class="w-full px-4 py-4 rounded-2xl bg-stone-50 border-stone-100 text-xs font-black uppercase tracking-widest text-stone-600 appearance-none cursor-pointer focus:ring-2 focus:ring-emerald-500">
                        <option value="All">All Cuisines</option>
                        <option value="Myanmar" <?php echo $cuisine == 'Myanmar' ? 'selected' : ''; ?>>Myanmar</option>
                        <option value="Italian" <?php echo $cuisine == 'Italian' ? 'selected' : ''; ?>>Italian</option>
                        <option value="Thai" <?php echo $cuisine == 'Thai' ? 'selected' : ''; ?>>Thai</option>
                        <option value="Japanese" <?php echo $cuisine == 'Japanese' ? 'selected' : ''; ?>>Japanese</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <select name="dietary" onchange="this.form.submit()" class="w-full px-4 py-4 rounded-2xl bg-stone-50 border-stone-100 text-xs font-black uppercase tracking-widest text-stone-600 appearance-none cursor-pointer focus:ring-2 focus:ring-emerald-500">
                        <option value="All">All Diet</option>
                        <option value="Vegetarian" <?php echo $dietary == 'Vegetarian' ? 'selected' : ''; ?>>Vegetarian</option>
                        <option value="Vegan" <?php echo $dietary == 'Vegan' ? 'selected' : ''; ?>>Vegan</option>
                        <option value="Gluten-Free" <?php echo $dietary == 'Gluten-Free' ? 'selected' : ''; ?>>Gluten-Free</option>
                        <option value="Non-Vegetarian" <?php echo $dietary == 'Non-Vegetarian' ? 'selected' : ''; ?>>Non-Vegetarian</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <select name="difficulty" onchange="this.form.submit()" class="w-full px-4 py-4 rounded-2xl bg-stone-50 border-stone-100 text-xs font-black uppercase tracking-widest text-stone-600 appearance-none cursor-pointer focus:ring-2 focus:ring-emerald-500">
                        <option value="All">All Levels</option>
                        <option value="Easy" <?php echo $difficulty == 'Easy' ? 'selected' : ''; ?>>Easy</option>
                        <option value="Medium" <?php echo $difficulty == 'Medium' ? 'selected' : ''; ?>>Medium</option>
                        <option value="Hard" <?php echo $difficulty == 'Hard' ? 'selected' : ''; ?>>Hard</option>
                    </select>
                </div>

                <button type="submit" class="md:col-span-3 bg-emerald-800 text-white px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-stone-900 transition-all shadow-xl active:scale-95">
                    Filter Recipes
                </button>
            </form>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 mt-20 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-serif italic text-stone-900">
                <?php 
                    if ($search) echo "Results for \"" . htmlspecialchars($search) . "\"";
                    else echo "The <span class='not-italic font-black text-emerald-800'>Curated</span> List";
                ?>
            </h2>
            <p class="text-stone-400 text-[10px] font-black uppercase tracking-widest mt-2">Showing <?php echo count($recipes); ?> Culinary Creations</p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <?php if (empty($recipes)): ?>
            <div class="text-center py-32 bg-white rounded-[3rem] border border-dashed border-stone-200 shadow-sm">
                <p class="text-stone-400 italic font-serif text-lg">No recipes match your current filters...</p>
                <a href="recipes.php" class="mt-6 inline-block text-emerald-800 font-black text-[10px] uppercase tracking-widest border-b-2 border-emerald-800 pb-1">Reset All Filters</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                <?php foreach ($recipes as $recipe): ?>
                <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-xl shadow-stone-200/40 hover:shadow-2xl transition-all duration-500 border border-stone-50 flex flex-col">
                    <div class="relative h-80 overflow-hidden">
                        <img src="<?php echo htmlspecialchars($recipe['image_url']); ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.5s]"
                             alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                        
                        <div class="absolute top-6 left-6">
                            <span class="bg-black/20 backdrop-blur-xl border border-white/30 text-white px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-lg">
                                <?php echo htmlspecialchars($recipe['cuisine_type']); ?>
                            </span>
                        </div>
                    </div>

                    <div class="p-10 flex flex-col flex-grow">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-emerald-600 text-[9px] font-black uppercase tracking-widest">
                                ⚡ <?php echo $recipe['difficulty']; ?>
                            </span>
                            <span class="text-stone-300 text-[9px] font-black uppercase tracking-widest">
                                <?php echo $recipe['dietary_preference']; ?>
                            </span>
                        </div>
                        
                        <h3 class="text-2xl font-serif text-stone-900 mb-4 group-hover:text-emerald-800 transition-colors leading-tight">
                            <?php echo htmlspecialchars($recipe['title']); ?>
                        </h3>
                        
                        <p class="text-stone-500 text-sm line-clamp-2 font-light leading-relaxed mb-8 italic">
                            <?php echo htmlspecialchars($recipe['description']); ?>
                        </p>
                        
                        <div class="mt-auto pt-8 border-t border-stone-50">
                            <a href="recipe_detail.php?id=<?php echo $recipe['recipe_id']; ?>" class="w-full flex justify-center items-center gap-3 bg-stone-900 text-white py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.3em] hover:bg-emerald-800 transition-all shadow-lg active:scale-95">
                                View Detail
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php include 'includes/footer.php'; ?>