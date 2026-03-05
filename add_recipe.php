<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php';

// Login မဝင်ထားရင် ပေးမဝင်ရန်
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $cuisine = $_POST['cuisine'];
    $difficulty = $_POST['difficulty'];
    $dietary = $_POST['dietary'];
    $user_id = $_SESSION['user_id'];

    // Image Upload Logic
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    
    $image_name = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO recipes (title, description, image_url, cuisine_type, difficulty, dietary_preference, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $target_file, $cuisine, $difficulty, $dietary, $user_id]);
            $success = "Recipe posted successfully!";
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Failed to upload image.";
    }
}
?>

<div class="bg-stone-50 min-h-screen pb-20">
    <header class="bg-emerald-800 py-16 text-center text-white">
        <h1 class="text-4xl font-black tracking-tighter">Share Your Recipe</h1>
        <p class="text-emerald-100 opacity-80 mt-2 italic">Inspire others with your culinary creations.</p>
    </header>

    <main class="max-w-4xl mx-auto px-6 -mt-10">
        <div class="bg-white p-10 rounded-[3rem] shadow-xl border border-stone-100">
            <?php if($success): ?>
                <div class="bg-emerald-50 text-emerald-700 p-5 rounded-2xl mb-8 font-bold border border-emerald-100">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-8">
                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Recipe Title</label>
                    <input type="text" name="title" required placeholder="e.g. Classic Mohinga" 
                           class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-bold text-slate-700 transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Cuisine Type</label>
                        <input type="text" name="cuisine" required placeholder="e.g. Burmese, Italian..." 
                               class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-bold text-slate-700">         
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Difficulty</label>
                        <select name="difficulty" class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-bold text-stone-600">
                            <option value="Easy">Easy</option>
                            <option value="Intermediate">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Dietary</label>
                        <select name="dietary" class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-bold text-stone-600">
                            <option value="Non-Veg">Non-Veg</option>
                            <option value="Vegetarian">Vegetarian</option>
                            <option value="Vegan">Vegan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Food Photo</label>
                    <input type="file" name="image" required class="w-full p-4 border-2 border-dashed border-stone-200 rounded-2xl text-stone-400 font-medium">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Ingredients & Instructions</label>
                    <textarea name="description" rows="8" required placeholder="List ingredients and step-by-step instructions..." 
                              class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-medium transition-all"></textarea>
                </div>

                <button type="submit" class="w-full bg-emerald-800 text-white py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-700 shadow-xl transition-all">
                    Publish Recipe
                </button>
            </form>
        </div>
    </main>
</div>

<?php // include 'includes/footer.php'; ?>