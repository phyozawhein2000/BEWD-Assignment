<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<div class="bg-white min-h-screen pb-32">
    <header class="py-24 px-6 border-b border-stone-100 text-center">
        <span class="text-[10px] font-bold tracking-[0.5em] uppercase text-emerald-600 mb-4 block">Legal & Safety</span>
        <h1 class="text-5xl md:text-6xl font-serif text-stone-900 italic">Privacy Policy</h1>
        <p class="text-stone-400 mt-6 max-w-lg mx-auto font-light leading-relaxed italic">
            Your trust is our most important ingredient. Here is how we protect your data and respect your privacy.
        </p>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-20">
        <section class="mb-16">
            <h2 class="text-2xl font-serif text-stone-800 mb-6">Introduction</h2>
            <p class="text-stone-500 font-light leading-relaxed">
                Thank you for being a part of the FoodFusion community. We value your privacy and are committed to protecting your personal information. This Privacy Policy outlines how we collect, use, and safeguard the data you provide while using our platform.
            </p>
        </section>

        <section class="mb-16 grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="p-10 bg-stone-50 rounded-[2.5rem] border border-stone-100">
                <h3 class="text-lg font-serif text-stone-900 mb-4">Information We Collect</h3>
                <ul class="text-stone-500 text-sm space-y-3 font-light">
                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-emerald-500 rounded-full"></span> Name & Contact Information</li>
                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-emerald-500 rounded-full"></span> User-Submitted Content & Recipes</li>
                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-emerald-500 rounded-full"></span> Technical Log Data (IP, Browser)</li>
                </ul>
            </div>
            <div class="p-10 bg-emerald-900 rounded-[2.5rem] text-emerald-100">
                <h3 class="text-lg font-serif text-white mb-4">How We Use It</h3>
                <ul class="text-sm space-y-3 font-light opacity-80">
                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-emerald-400 rounded-full"></span> To manage and verify your account</li>
                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-emerald-400 rounded-full"></span> To improve platform functionality</li>
                    <li class="flex items-center gap-2"><span class="w-1 h-1 bg-emerald-400 rounded-full"></span> To share optional newsletters</li>
                </ul>
            </div>
        </section>

        <section class="mb-16 space-y-12">
            <div class="border-l-2 border-emerald-100 pl-8 py-4">
                <h2 class="text-2xl font-serif text-stone-800 mb-4">Public Content & Sharing</h2>
                <p class="text-stone-500 font-light leading-relaxed">
                    Any recipes or comments you submit to the Community Section are public and visible to other users. However, your private credentials (passwords) and personal email address are strictly confidential. We do not sell or trade your personal data to third-party organizations.
                </p>
            </div>

            <div class="border-l-2 border-emerald-100 pl-8 py-4">
                <h2 class="text-2xl font-serif text-stone-800 mb-4">Cookies & Analytics</h2>
                <p class="text-stone-500 font-light leading-relaxed">
                    We use cookies to enhance your browsing experience and analyze site traffic. This helps us understand which features you enjoy most. You can choose to disable cookies through your individual browser settings at any time.
                </p>
            </div>

            <div class="border-l-2 border-emerald-100 pl-8 py-4">
                <h2 class="text-2xl font-serif text-stone-800 mb-4">Data Security</h2>
                <p class="text-stone-500 font-light leading-relaxed">
                    We implement a variety of security measures to maintain the safety of your personal information. Your data is stored on secure servers, and sensitive information is protected via encryption.
                </p>
            </div>
        </section>

        <section class="mt-24 pt-16 border-t border-stone-100 text-center">
            <h2 class="text-xl font-serif text-stone-900 mb-4">Questions about your data?</h2>
            <p class="text-stone-400 font-light mb-8 italic">
                If you have any questions regarding this policy or your personal data, feel free to reach out.
            </p>
            <a href="contact.php" class="text-[10px] font-bold uppercase tracking-[0.3em] text-emerald-700 hover:text-emerald-500 transition-colors border-b border-stone-200 pb-2">
                Contact Privacy Team
            </a>
        </section>
    </main>
</div>

<?php include 'includes/footer.php'; ?>