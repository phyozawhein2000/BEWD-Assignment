<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<div class="bg-white min-h-screen pb-32">
    <header class="py-24 px-6 border-b border-stone-100 text-center">
        <span class="text-[10px] font-bold tracking-[0.5em] uppercase text-emerald-600 mb-4 block">Transparency</span>
        <h1 class="text-5xl md:text-6xl font-serif text-stone-900 italic">Cookie Policy</h1>
        <p class="text-stone-400 mt-6 max-w-lg mx-auto font-light leading-relaxed italic">
            How we use small bits of data to improve your culinary and learning experience.
        </p>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-20">
        <section class="mb-20">
            <h2 class="text-2xl font-serif text-stone-800 mb-6">What are Cookies?</h2>
            <p class="text-stone-500 font-light leading-relaxed">
                Cookies are small text files stored on your device (computer or mobile) by your web browser when you visit a website. They act as a memory for the website, allowing it to remember your actions and preferences over a period of time, making your browsing experience smoother and more personalized.
            </p>
        </section>

        <section class="mb-20">
            <h2 class="text-2xl font-serif text-stone-800 mb-10">How We Use Cookies</h2>
            
            <div class="space-y-8">
                <div class="flex flex-col md:flex-row gap-6 p-8 bg-stone-50 rounded-[2rem] border border-stone-100">
                    <div class="w-12 h-12 bg-emerald-800 rounded-2xl shrink-0 flex items-center justify-center shadow-lg shadow-emerald-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-serif text-stone-900 mb-2">Essential Cookies</h4>
                        <p class="text-stone-500 text-sm font-light leading-relaxed">
                            These are strictly necessary for the operation of our website. They include cookies that enable you to log into secure areas of the site. Without these, our website cannot function correctly.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-6 p-8 bg-white rounded-[2rem] border border-stone-100">
                    <div class="w-12 h-12 bg-stone-100 rounded-2xl shrink-0 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-serif text-stone-900 mb-2">Performance & Analytics</h4>
                        <p class="text-stone-500 text-sm font-light leading-relaxed">
                            These allow us to recognize and count the number of visitors and see how visitors move around our website. This helps us improve the way our website works, for example, by ensuring that users find what they are looking for easily.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-6 p-8 bg-stone-50 rounded-[2rem] border border-stone-100">
                    <div class="w-12 h-12 bg-amber-100 rounded-2xl shrink-0 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-serif text-stone-900 mb-2">Functional Cookies</h4>
                        <p class="text-stone-500 text-sm font-light leading-relaxed">
                            These are used to recognize you when you return to our website. This enables us to personalize our content for you and remember your preferences, such as your choice of language or region.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-20">
            <h2 class="text-2xl font-serif text-stone-800 mb-6">Managing Your Choice</h2>
            <p class="text-stone-500 font-light leading-relaxed mb-8">
                You can choose to block or delete cookies through your browser settings. However, please be aware that if you use your browser settings to block all cookies (including essential cookies), you may not be able to access all or parts of our site.
            </p>
            <div class="flex gap-4">
                <a href="https://support.google.com/chrome/answer/95647" target="_blank" class="text-[10px] font-bold uppercase tracking-widest text-stone-400 hover:text-stone-900 transition-colors border-b border-stone-200 pb-1">Chrome Settings</a>
                <a href="https://support.apple.com/guide/safari/manage-cookies-sfri11471/mac" target="_blank" class="text-[10px] font-bold uppercase tracking-widest text-stone-400 hover:text-stone-900 transition-colors border-b border-stone-200 pb-1">Safari Settings</a>
            </div>
        </section>

        <footer class="mt-24 pt-10 border-t border-stone-100 italic text-[11px] text-stone-400 text-center">
            Last Updated: March 2026
        </footer>
    </main>
</div>

<?php include 'includes/footer.php'; ?>