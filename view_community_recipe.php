<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php';

$submission_id = $_GET['id'] ?? null;
if (!$submission_id) { header("Location: community.php"); exit; }

// Recipe Data ဆွဲထုတ်ခြင်း
$stmt = $pdo->prepare("SELECT c.*, u.first_name, u.last_name FROM community_cookbook c JOIN users u ON c.user_id = u.id WHERE c.submission_id = ?");
$stmt->execute([$submission_id]);
$post = $stmt->fetch();

// Like စစ်ဆေးခြင်း
$isLiked = false;
if (isset($_SESSION['user_id'])) {
    $likeStmt = $pdo->prepare("SELECT 1 FROM cookbook_likes WHERE submission_id = ? AND user_id = ?");
    $likeStmt->execute([$submission_id, $_SESSION['user_id']]);
    $isLiked = $likeStmt->fetchColumn();
}

// Comments ဆွဲထုတ်ခြင်း
$commentStmt = $pdo->prepare("SELECT cc.*, u.first_name FROM cookbook_comments cc JOIN users u ON cc.user_id = u.id WHERE cc.submission_id = ? ORDER BY cc.created_at DESC");
$commentStmt->execute([$submission_id]);
$comments = $commentStmt->fetchAll();
?>

<div class="bg-stone-50 min-h-screen pt-32 pb-20">
    <article class="max-w-4xl mx-auto px-6">
        <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-stone-100 mb-10">
         <?php if (!empty($post['image_url']) && $post['image_url'] !== 'default_recipe.jpg'): ?>
                <div class="w-full h-[400px] overflow-hidden rounded-[2rem] mb-8">
                    <img src="uploads/cookbook/<?php echo htmlspecialchars($post['image_url']); ?>" 
                         class="w-full h-full object-cover shadow-inner" 
                         alt="<?php echo htmlspecialchars($post['recipe_title']); ?>">
                </div>
            <?php endif; ?>   
    <h1 class="text-4xl font-black text-slate-800 mb-6"><?php echo htmlspecialchars($post['recipe_title']); ?></h1>
    
    <div class="flex flex-wrap items-center justify-between py-6 border-y border-stone-50 gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-800 rounded-full flex items-center justify-center text-white font-bold">
                <?php echo strtoupper(substr($post['first_name'], 0, 1)); ?>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase text-stone-400">Shared by</p>
                <p class="font-bold text-slate-700"><?php echo htmlspecialchars($post['first_name'] . ' ' . $post['last_name']); ?></p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="toggle_like.php?id=<?php echo $submission_id; ?>" 
               class="flex items-center gap-3 px-6 py-3 rounded-2xl transition-all <?php echo $isLiked ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-stone-100 text-stone-500 hover:bg-stone-200'; ?> font-black text-xs uppercase">
                <span><?php echo $isLiked ? '❤️ Liked' : '🤍 Like'; ?></span>
                <span class="opacity-50"><?php echo $post['totalLike']; ?></span>
            </a>
        </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-4">
    <span class="px-4 py-1.5 bg-stone-100 text-stone-600 rounded-full text-xs font-black uppercase tracking-widest border border-stone-200">
        Cuisine: <?php echo htmlspecialchars($post['cuisine_type'] ?? 'N/A'); ?>
    </span>
    <span class="px-4 py-1.5 bg-stone-100 text-stone-600 rounded-full text-xs font-black uppercase tracking-widest border border-stone-200">
        Difficulty: <?php echo htmlspecialchars($post['difficulty'] ?? 'N/A'); ?>
    </span>
</div>

<div class="mt-8 prose prose-stone max-w-none italic text-stone-600 leading-relaxed break-words">
    <?php echo nl2br(htmlspecialchars($post['recipe_content'])); ?>
</div>

</div>

        <section class="bg-white rounded-[3rem] p-10 shadow-sm border border-stone-100">
            <h3 class="text-2xl font-black text-slate-800 mb-8">Comments (<?php echo count($comments); ?>)</h3>

            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="post_comment.php" method="POST" class="mb-12">
                    <input type="hidden" name="submission_id" value="<?php echo $submission_id; ?>">
                    <textarea name="comment" required class="w-full p-6 bg-stone-50 rounded-2xl border-none focus:ring-2 focus:ring-emerald-500 mb-4" placeholder="Share your thoughts..."></textarea>
                    <button type="submit" class="bg-emerald-800 text-white px-8 py-4 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition-all">Post Comment</button>
                </form>
            <?php else: ?>
                <div class="bg-stone-50 p-8 rounded-2xl text-center mb-10 border border-dashed border-stone-200">
                    <p class="text-stone-500 italic text-sm">Please <a href="auth/login.php" class="text-emerald-700 font-bold underline">Login</a> to join the conversation.</p>
                </div>
            <?php endif; ?>

            <div class="space-y-6">
                <?php foreach ($comments as $c): ?>
                    <div class="group relative bg-stone-50/50 p-6 rounded-2xl border border-stone-100 transition-all hover:bg-white hover:shadow-md">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-black text-emerald-800 uppercase tracking-widest"><?php echo htmlspecialchars($c['first_name']); ?></span>
                            <span class="text-[10px] text-stone-300 font-bold"><?php echo date('M d, Y', strtotime($c['created_at'])); ?></span>
                        </div>
                        <p class="text-stone-600 text-sm italic"><?php echo nl2br(htmlspecialchars($c['comment'])); ?></p>
                        
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $c['user_id']): ?>
                            <a href="delete_comment.php?comment_id=<?php echo $c['comment_id']; ?>" 
                               onclick="return confirm('Delete comment?')"
                               class="absolute top-4 right-4 text-stone-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all text-[10px] font-black">✕</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </article>
</div>