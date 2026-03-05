<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php'; 

// 1. Search & Filter Logic
$search = $_GET['search'] ?? '';
$cuisine = $_GET['cuisine'] ?? 'All';

try {
    // Base Query
    $sql = "SELECT * FROM recipes WHERE title LIKE :search";
    $params = [':search' => "%$search%"];

    // Cuisine Filter (All မဟုတ်လျှင် SQL တွင် ထည့်ပေါင်းမည်)
    if ($cuisine !== 'All') {
        $sql .= " AND cuisine_type = :cuisine";
        $params[':cuisine'] = $cuisine;
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
    <header class="bg-emerald-800 py-20 text-center text-white relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-4xl md:text-6xl font-black tracking-tighter mb-4">Explore Recipes</h1>
            <p class="text-emerald-100 opacity-80 max-w-2xl mx-auto px-6 italic text-lg">
                Discover the best culinary secrets from our community of passionate chefs.
            </p>
        </div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-emerald-700 rounded-full opacity-20"></div>
    </header>

    <section class="max-w-7xl mx-auto px-6 -mt-10 relative z-20">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl border border-stone-100">
            <form action="recipes.php" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                
                <div class="md:col-span-6 relative">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Search by recipe name..." 
                           class="w-full pl-14 pr-6 py-5 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 transition-all font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute left-5 top-5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <div class="md:col-span-4">
                    <select name="cuisine" onchange="this.form.submit()" 
                            class="w-full px-6 py-5 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-bold text-stone-600 appearance-none cursor-pointer">
                        <option value="All" <?php echo $cuisine == 'All' ? 'selected' : ''; ?>>All Cuisines</option>
                        <option value="Myanmar" <?php echo $cuisine == 'Myanmar' ? 'selected' : ''; ?>>🇲🇲 Myanmar</option>
                        <option value="Italian" <?php echo $cuisine == 'Italian' ? 'selected' : ''; ?>>🇮🇹 Italian</option>
                        <option value="Thai" <?php echo $cuisine == 'Thai' ? 'selected' : ''; ?>>🇹🇭 Thai</option>
                        <option value="Chinese" <?php echo $cuisine == 'Chinese' ? 'selected' : ''; ?>>🇨🇳 Chinese</option>
                        <option value="Japanese" <?php echo $cuisine == 'Japanese' ? 'selected' : ''; ?>>🇯🇵 Japanese</option>
                    </select>
                </div>

                <button type="submit" class="md:col-span-2 bg-emerald-800 text-white px-6 py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg active:scale-95">
                    Search
                </button>
            </form>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 mt-16 flex flex-col md:flex-row justify-between items-end gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tighter">
                <?php 
                    if ($search) echo "Results for '" . htmlspecialchars($search) . "'";
                    elseif ($cuisine !== 'All') echo $cuisine . " Specialties";
                    else echo "Trending Recipes";
                ?>
            </h2>
            <p class="text-stone-400 text-sm font-medium italic mt-1">Showing <?php echo count($recipes); ?> curated recipes.</p>
        </div>

        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="add_recipe.php" class="flex items-center gap-3 bg-emerald-100 text-emerald-800 px-8 py-4 rounded-2xl font-black text-sm hover:bg-emerald-800 hover:text-white transition-all group shadow-sm border border-emerald-200">
                <div class="bg-emerald-800 text-white p-1 rounded-lg group-hover:bg-white group-hover:text-emerald-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                SHARE YOUR RECIPE
            </a>
        <?php else: ?>
            <a href="auth/login.php" class="flex items-center gap-3 bg-stone-100 text-stone-500 px-8 py-4 rounded-2xl font-black text-sm hover:bg-stone-200 transition-all border border-stone-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                LOGIN TO SHARE
            </a>
        <?php endif; ?>
    </section>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <?php if (empty($recipes)): ?>
            <div class="text-center py-24 bg-white rounded-[3rem] border-2 border-dashed border-stone-200 shadow-inner">
                <div class="w-20 h-20 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-700">No recipes found</h3>
                <p class="text-stone-400 mt-2">Try adjusting your search or filters.</p>
                <a href="recipes.php" class="mt-6 inline-block text-emerald-700 font-black text-sm underline tracking-widest">CLEAR ALL FILTERS</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php foreach ($recipes as $recipe): ?>
                <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-stone-100 flex flex-col">
                    
                    <div class="relative h-72 overflow-hidden">
                        <img src="<?php echo htmlspecialchars($recipe['image_url']); ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                        
                        <div class="absolute top-6 left-6 flex flex-col gap-2">
                            <span class="bg-emerald-600/90 backdrop-blur-md text-white px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg">
                                <?php echo htmlspecialchars($recipe['cuisine_type']); ?>
                            </span>
                        </div>
                        <div class="absolute bottom-6 left-6">
                            <span class="bg-white/90 backdrop-blur-md text-slate-800 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg">
                                ⚡ <?php echo $recipe['difficulty']; ?>
                            </span>
                        </div>
                    </div>

                    <div class="p-10 flex flex-col flex-grow">
                        <h3 class="text-2xl font-black text-slate-800 mb-4 group-hover:text-emerald-700 transition-colors leading-tight">
                            <?php echo htmlspecialchars($recipe['title']); ?>
                        </h3>
                        <p class="text-stone-500 text-sm line-clamp-3 italic leading-relaxed mb-8">
                            <?php echo htmlspecialchars($recipe['description']); ?>
                        </p>
                        
                        <div class="mt-auto pt-8 border-t border-stone-50 flex justify-between items-center">
                            <span class="text-[10px] font-black text-stone-400 uppercase tracking-[0.2em]">
                                <?php echo $recipe['dietary_preference']; ?>
                            </span>
                            <a href="recipe_detail.php?id=<?php echo $recipe['recipe_id']; ?>" class="text-emerald-800 font-black text-xs hover:text-emerald-600 transition-colors flex items-center gap-2">
                                VIEW RECIPE 
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php //include 'includes/footer.php'; ?>