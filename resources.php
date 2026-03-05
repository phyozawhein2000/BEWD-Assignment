<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php';
require_once 'config/db.php'; 

try {
    $stmt = $pdo->query("SELECT c.*, u.first_name FROM community_cookbook c 
                          JOIN users u ON c.user_id = u.id 
                          ORDER BY c.submitted_at DESC LIMIT 3");
    $community_posts = $stmt->fetchAll();
} catch (PDOException $e) { $community_posts = []; }
?>

<div class="bg-white min-h-screen">
    <header class="py-24 px-6 border-b border-stone-100 text-center">
        <span class="text-[10px] font-bold tracking-[0.5em] uppercase text-emerald-600 mb-4 block">Essentials</span>
        <h1 class="text-5xl md:text-7xl font-serif text-stone-900 italic">Kitchen Resources</h1>
        <p class="text-stone-400 mt-6 max-w-lg mx-auto font-light leading-relaxed">
            A collection of fundamental tools and guides to elevate your daily cooking experience.
        </p>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-20">
        <section class="mb-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h2 class="text-3xl font-serif text-stone-900 mb-6">Quick Conversion</h2>
                    <p class="text-stone-500 font-light mb-8 italic">No more guessing. Convert your kitchen measurements instantly.</p>
                    
                    <div class="space-y-6 bg-stone-50 p-10 rounded-[2.5rem] border border-stone-100">
                        <div class="flex justify-between items-center text-sm border-b border-stone-200 pb-4">
                            <span class="text-stone-400 uppercase tracking-widest font-bold text-[10px]">1 Cup (US)</span>
                            <span class="text-stone-800 font-serif text-lg">240 ml</span>
                        </div>
                        <div class="flex justify-between items-center text-sm border-b border-stone-200 pb-4">
                            <span class="text-stone-400 uppercase tracking-widest font-bold text-[10px]">1 Tablespoon</span>
                            <span class="text-stone-800 font-serif text-lg">15 ml</span>
                        </div>
                        <div class="flex justify-between items-center text-sm border-b border-stone-200 pb-4">
                            <span class="text-stone-400 uppercase tracking-widest font-bold text-[10px]">1 Ounce (oz)</span>
                            <span class="text-stone-800 font-serif text-lg">28.35 g</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-stone-400 uppercase tracking-widest font-bold text-[10px]">180°C (Gas Mark 4)</span>
                            <span class="text-stone-800 font-serif text-lg">350°F</span>
                        </div>
                    </div>
                </div>
                <div class="aspect-square bg-stone-100 overflow-hidden rounded-[3rem]">
                    <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d" class="w-full h-full object-cover grayscale-[30%] hover:grayscale-0 transition-all duration-1000" alt="Kitchen Tools">
                </div>
            </div>
        </section>
        <section class="py-24 border-t border-stone-100">
    <div class="flex justify-between items-end mb-16">
        <div>
            <span class="text-[9px] font-black uppercase tracking-[0.3em] text-emerald-600 mb-2 block">Shared Knowledge</span>
            <h2 class="text-3xl font-serif text-stone-900">From Our Community</h2>
        </div>
        <a href="community.php" class="text-[10px] font-bold uppercase tracking-widest text-stone-400 hover:text-stone-800 transition-colors border-b border-stone-200 pb-1">View Cookbook</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php foreach ($community_posts as $post): ?>
            <div class="bg-stone-50 p-8 rounded-[2rem] border border-transparent hover:border-emerald-100 hover:bg-white transition-all duration-500 group">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-1 h-1 rounded-full bg-emerald-500"></div>
                    <span class="text-[9px] font-bold text-stone-400 uppercase tracking-tighter">Member Recipe</span>
                </div>
                
                <h4 class="text-xl font-serif text-stone-800 mb-4 group-hover:text-emerald-700 transition-colors italic">
                    "<?php echo htmlspecialchars($post['recipe_title']); ?>"
                </h4>
                
                <p class="text-stone-500 text-sm font-light leading-relaxed line-clamp-3 mb-8">
                    <?php echo htmlspecialchars($post['recipe_content']); ?>
                </p>

                <div class="flex items-center justify-between pt-6 border-t border-stone-200/50">
                    <span class="text-[10px] font-bold text-stone-400 uppercase tracking-widest italic">By <?php echo htmlspecialchars($post['first_name']); ?></span>
                    <a href="view_community_recipe.php?id=<?php echo $post['submission_id']; ?>" class="text-emerald-600 text-sm">→</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="mt-16 p-10 bg-emerald-50 rounded-[2.5rem] border border-emerald-100 text-center">
    <p class="text-emerald-800 font-serif text-lg mb-4 italic">Have your own kitchen secret or a family guide?</p>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="submit_cookbook.php" 
           class="inline-block bg-emerald-800 text-white px-10 py-4 rounded-xl font-bold text-[10px] uppercase tracking-[0.2em] hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-800/20">
            Submit Your Entry
        </a>
    <?php else: ?>
        <div class="space-y-4">
            <a href="auth/login.php?redirect=../resources.php" 
               class="inline-block bg-amber-500 text-white px-10 py-4 rounded-xl font-bold text-[10px] uppercase tracking-[0.2em] hover:bg-amber-600 transition-all shadow-lg shadow-amber-500/20">
                Login to Submit
            </a>
            <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest block">
                You must be logged in to share your recipes.
            </p>
        </div>
    <?php endif; ?>
</div>


</section>

        <section class="mb-32">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-serif text-stone-900">Culinary Fundamentals</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="group">
                    <div class="h-64 bg-stone-50 mb-6 overflow-hidden rounded-3xl border border-stone-100">
                        <img src="https://images.unsplash.com/photo-1594385208974-2e75f9d8ad48" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">
                    </div>
                    <h3 class="text-xl font-serif text-stone-800 mb-3">Knife Skills 101</h3>
                    <p class="text-stone-400 text-sm font-light leading-relaxed mb-4">Master the art of dicing, slicing, and julienne like a professional chef.</p>
                    <a href="#" class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 border-b border-emerald-100 pb-1">Read Guide</a>
                </div>

                <div class="group">
                    <div class="h-64 bg-stone-50 mb-6 overflow-hidden rounded-3xl border border-stone-100">
                        <img src="https://images.unsplash.com/photo-1581009146145-b5ef03a7401c" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">
                    </div>
                    <h3 class="text-xl font-serif text-stone-800 mb-3">Pantry Essentials</h3>
                    <p class="text-stone-400 text-sm font-light leading-relaxed mb-4">The must-have spices and ingredients to stock for global flavors.</p>
                    <a href="#" class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 border-b border-emerald-100 pb-1">Read Guide</a>
                </div>

                <div class="group">
                    <div class="h-64 bg-stone-50 mb-6 overflow-hidden rounded-3xl border border-stone-100">
                        <img src="https://images.unsplash.com/photo-1547592166-23ac45744acd" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">
                    </div>
                    <h3 class="text-xl font-serif text-stone-800 mb-3">Seasonal Produce</h3>
                    <p class="text-stone-400 text-sm font-light leading-relaxed mb-4">A month-by-month guide to choosing the freshest ingredients.</p>
                    <a href="#" class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 border-b border-emerald-100 pb-1">Read Guide</a>
                </div>
            </div>
        </section>

        <section class="bg-stone-900 py-32 px-10 rounded-[4rem] text-center relative overflow-hidden">
            <div class="relative z-10">
                <svg class="w-12 h-12 text-emerald-500 mx-auto mb-8 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V12C14.017 12.5523 13.5693 13 13.017 13H11.017V21H14.017ZM5.01705 21L5.01705 18C5.01705 16.8954 5.91243 16 7.01705 16H10.017C10.5693 16 11.017 15.5523 11.017 15V9C11.017 8.44772 10.5693 8 10.017 8H6.01705C5.46477 8 5.01705 8.44772 5.01705 9V12C5.01705 12.5523 4.56932 13 4.01705 13H2.01705V21H5.01705Z" />
                </svg>
                <h2 class="text-2xl md:text-4xl font-serif text-white italic leading-snug max-w-2xl mx-auto">
                    "Cooking is an observation-based process that you can't learn from an exact recipe."
                </h2>
                <p class="text-emerald-500 font-bold uppercase tracking-[0.3em] text-[10px] mt-8">— Chef Michael Pollan</p>
            </div>
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
        </section>
    </main>
</div>

<?php //include 'includes/footer.php'; ?>