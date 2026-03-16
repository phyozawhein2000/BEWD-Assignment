<footer class="bg-stone-950 text-stone-400 pt-16 pb-12">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 border-b border-stone-800/50 pb-12">
        
        <div class="md:col-span-1">
            <h2 class="text-white text-2xl font-bold mb-6 italic tracking-tight">Food<span class="text-orange-500 font-normal">Fusion</span></h2>
            <p class="text-sm leading-relaxed mb-6">
                Fostering a vibrant community for food lovers to share, learn, and create.
            </p>
            <div class="flex space-x-3">
                <a href="https://t.me/Pz_1000" target="_blank" class="p-2.5 rounded-full bg-stone-900 hover:bg-orange-500 hover:text-white transition-all duration-300" aria-label="Telegram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                </a>

                <a href="https://www.facebook.com/phyo.zaw.hein.764520/" target="_blank" class="p-2.5 rounded-full bg-stone-900 hover:bg-orange-500 hover:text-white transition-all duration-300" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                </a>

                <a href="https://www.youtube.com/@PhyoZawHein-p5k" target="_blank" class="p-2.5 rounded-full bg-stone-900 hover:bg-orange-500 hover:text-white transition-all duration-300" aria-label="YouTube">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 2-2 68.4 68.4 0 0 1 15 0 2 2 0 0 1 2 2 24.12 24.12 0 0 1 0 10 2 2 0 0 1-2 2 68.4 68.4 0 0 1-15 0 2 2 0 0 1-2-2z"></path><path d="m10 15 5-3-5-3z"></path></svg>
                </a>

                <a href="https://www.tiktok.com/@yourusername" target="_blank" class="p-2.5 rounded-full bg-stone-900 hover:bg-orange-500 hover:text-white transition-all duration-300" aria-label="TikTok">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
                </a>
            </div>
        </div>

        <div class="flex flex-col space-y-4 text-sm">
            <h3 class="text-white font-semibold uppercase tracking-wider text-[10px]">Resources</h3>
            <a href="privacy.php" class="hover:text-orange-500 transition-colors">Privacy Policy</a>
            <a href="cookies.php" class="hover:text-orange-500 transition-colors">Cookie Preferences</a>
            <a href="privacy.php" class="hover:text-orange-500 transition-colors">Terms of Service</a>
        </div>

        <div class="flex flex-col space-y-4 text-sm">
            <h3 class="text-white font-semibold uppercase tracking-wider text-[10px]">Community</h3>
            <a href="contact.php" class="hover:text-orange-500 transition-colors">Help Center</a>
            <a href="contact.php" class="hover:text-orange-500 transition-colors">Guidelines</a>
            <a href="contact.php" class="hover:text-orange-500 transition-colors">Contact Us</a>
        </div>

        <div class="flex flex-col space-y-4">
            <h3 class="text-white font-semibold uppercase tracking-wider text-[10px]">Stay Updated</h3>
            <p class="text-xs text-stone-500">The best recipes, delivered to your inbox.</p>
            
            <form id="footerNewsletterForm" class="flex relative group">
                <input type="email" id="footerSubEmail" placeholder="Email Address" required
                       class="bg-stone-900 border border-stone-800 rounded-l-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-500 w-full transition-all text-white placeholder:text-stone-600">
                
                <button type="submit" id="footerSubBtn" 
                        class="bg-orange-600 text-white px-6 py-3 rounded-r-xl hover:bg-orange-500 transition text-xs font-bold uppercase tracking-widest shrink-0">
                    Join
                </button>
            </form>
            <p id="footerSubMsg" class="text-[9px] font-bold uppercase tracking-[0.2em] mt-2 hidden"></p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 mt-10 text-center">
        <p class="text-[10px] uppercase tracking-[0.3em] text-stone-600">
            © 2026 <span class="text-stone-500">FoodFusion</span>. Crafted with passion for foodies.
        </p>
    </div>
</footer>

<script>
document.getElementById('footerNewsletterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const emailInput = document.getElementById('footerSubEmail');
    const btn = document.getElementById('footerSubBtn');
    const msg = document.getElementById('footerSubMsg');

    btn.disabled = true;
    const originalBtnText = btn.innerText;
    btn.innerText = '...';

    fetch('subscribe_process.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'email=' + encodeURIComponent(emailInput.value)
    })
    .then(response => response.json())
    .then(data => {
        msg.classList.remove('hidden', 'text-red-400', 'text-orange-500');
        msg.innerText = data.message;

        if(data.status === 'success') {
            msg.classList.add('text-orange-500');
            emailInput.value = '';
            btn.innerText = 'Done';
        } else {
            msg.classList.add('text-red-400');
            btn.innerText = originalBtnText;
            btn.disabled = false;
        }
    })
    .catch(error => {
        msg.innerText = "Connection Error";
        msg.classList.remove('hidden', 'text-red-400');
        msg.classList.add('text-red-400');
        btn.disabled = false;
        btn.innerText = originalBtnText;
    });
});
</script>