<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php'; 
include 'includes/navbar.php'; 
require_once 'config/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);
            $success = "Your message has been sent successfully! We will get back to you soon.";
        } catch (PDOException $e) {
            $error = "Something went wrong. Please try again later.";
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<div class="bg-stone-50 min-h-screen pb-20">
    <header class="bg-emerald-800 py-16 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-black tracking-tighter mb-4">Contact Us</h1>
        <p class="text-emerald-100 opacity-80 max-w-2xl mx-auto px-6 italic">Have questions or recipe suggestions? We'd love to hear from you.</p>
    </header>

    <main class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 -mt-10">
        
        <div class="bg-emerald-900 p-10 md:p-16 rounded-[3rem] text-white shadow-2xl flex flex-col justify-between">
            <div>
                <h2 class="text-3xl font-black mb-8 italic">Get in touch with the FoodFusion Team.</h2>
                <div class="space-y-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-emerald-800 rounded-2xl flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-emerald-400 font-black uppercase text-[10px] tracking-widest mb-1">Email Us</p>
                            <p class="font-bold text-lg">support@foodfusion.com</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-emerald-800 rounded-2xl flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-emerald-400 font-black uppercase text-[10px] tracking-widest mb-1">Our Studio</p>
                            <p class="font-bold text-lg leading-relaxed">No. 123, Culinary Avenue,<br>Yangon, Myanmar.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-emerald-800">
                <p class="text-sm text-emerald-300 font-medium">Follow our journey on social media for daily recipe inspiration.</p>
            </div>
        </div>

        <div class="bg-white p-10 md:p-16 rounded-[3rem] shadow-xl border border-stone-100">
            <?php if($success): ?>
                <div class="bg-emerald-50 text-emerald-700 p-5 rounded-2xl mb-8 font-bold border border-emerald-100 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Full Name</label>
                        <input type="text" name="name" required class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-medium transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Email Address</label>
                        <input type="email" name="email" required class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-medium transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Subject</label>
                    <input type="text" name="subject" class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-medium transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-stone-400 mb-2 tracking-widest">Your Message</label>
                    <textarea name="message" rows="5" required class="w-full px-6 py-4 rounded-2xl bg-stone-50 border-none focus:ring-2 focus:ring-emerald-500 font-medium transition-all"></textarea>
                </div>
                <button type="submit" class="w-full bg-emerald-800 text-white py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-700 shadow-xl shadow-emerald-900/10 transition-all active:scale-[0.98]">
                    Send Message
                </button>
            </form>
        </div>

    </main>
</div>

<?php include 'includes/footer.php'; ?>