  <!-- FOOTER -->
 <footer class="bg-stone-950 text-stone-400 pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 border-b border-stone-800/50 pb-12">
    
    <div class="md:col-span-1">
      <h2 class="text-white text-2xl font-bold mb-6 italic tracking-tight">Food<span class="text-orange-500">Fusion</span></h2>
      <p class="text-sm leading-relaxed mb-6">
        Fostering a vibrant community for food lovers to share, learn, and create.
      </p>
      <div class="flex space-x-4">
        <a href="#" class="p-2 rounded-full bg-stone-900 hover:bg-orange-500 hover:text-white transition-all duration-300" aria-label="Instagram">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-instagram"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
        </a>
        <a href="#" class="p-2 rounded-full bg-stone-900 hover:bg-orange-500 hover:text-white transition-all duration-300" aria-label="Facebook">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
        </a>
        <a href="#" class="p-2 rounded-full bg-stone-900 hover:bg-orange-500 hover:text-white transition-all duration-300" aria-label="Twitter">
           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-twitter"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
        </a>
      </div>
    </div>

    <div class="flex flex-col space-y-4 text-sm">
      <h3 class="text-white font-semibold uppercase tracking-wider text-xs">Resources</h3>
      <a href="privacy.php" class="hover:text-orange-500 transition-colors">Privacy Policy</a>
      <a href="cookies.php" class="hover:text-orange-500 transition-colors">Cookie Preferences</a>
      <a href="#" class="hover:text-orange-500 transition-colors">Terms of Service</a>
    </div>

    <div class="flex flex-col space-y-4 text-sm">
      <h3 class="text-white font-semibold uppercase tracking-wider text-xs">Community</h3>
      <a href="#" class="hover:text-orange-500 transition-colors">Help Center</a>
      <a href="#" class="hover:text-orange-500 transition-colors">Guidelines</a>
      <a href="#" class="hover:text-orange-500 transition-colors">Contact Us</a>
    </div>

    <div class="flex flex-col space-y-4">
    <h3 class="text-white font-semibold uppercase tracking-wider text-xs">Stay Updated</h3>
    <p class="text-xs">The best recipes, delivered to your inbox.</p>
    
    <form id="footerNewsletterForm" class="flex relative">
        <input type="email" id="footerSubEmail" placeholder="Email" required
               class="bg-stone-900 border border-stone-800 rounded-l px-3 py-2 text-sm focus:outline-none focus:border-orange-500 w-full transition-all">
        
        <button type="submit" id="footerSubBtn" 
                class="bg-orange-600 text-white px-4 py-2 rounded-r hover:bg-orange-500 transition text-sm font-medium shrink-0">
            Join
        </button>
    </form>
    
    <p id="footerSubMsg" class="text-[10px] font-bold uppercase tracking-widest hidden"></p>
</div>


  </div>

  <div class="max-w-7xl mx-auto px-6 mt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 text-[10px] uppercase tracking-widest">
    <p>© 2026 FoodFusion. Crafted for foodies.</p>
    <div class="flex space-x-6">
      <span class="text-stone-600">All rights reserved.</span>
    </div>
  </div>
</footer>
<script>
document.getElementById('footerNewsletterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const emailInput = document.getElementById('footerSubEmail');
    const btn = document.getElementById('footerSubBtn');
    const msg = document.getElementById('footerSubMsg');

    btn.disabled = true;
    btn.innerText = '...';

    const formData = new FormData();
    formData.append('email', emailInput.value);

    // အရှေ့က ရေးခဲ့တဲ့ subscribe_process.php ကိုပဲ ပြန်သုံးပါမယ်
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
            btn.innerText = 'Join';
            btn.disabled = false;
        }
    })
    .catch(error => {
        msg.innerText = "Error connecting...";
        msg.classList.remove('hidden');
        btn.disabled = false;
    });
});
</script>