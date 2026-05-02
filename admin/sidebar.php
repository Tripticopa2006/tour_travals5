<button id="menu-btn" class="fixed top-4 left-4 z-50 md:hidden bg-slate-900 text-white p-2 rounded-md focus:outline-none">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
    </svg>
</button>

<div id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-slate-900 text-white p-5 shadow-2xl overflow-y-auto transition-transform duration-300 transform -translate-x-full md:translate-x-0 z-40">
    <h2 class="text-2xl font-bold mb-10 text-blue-400 flex items-center">
        <span class="mr-2">🌍</span> TravelMS
    </h2>
    
    <nav class="space-y-2">
        <a href="dashboard.php" class="block p-3 rounded hover:bg-blue-600 transition duration-200 bg-blue-600">📊 Dashboard</a>
        <a href="manage_packages.php" class="block p-3 rounded hover:bg-slate-800 transition">🗺️ View Packages</a>
        <a href="add_package.php" class="block p-3 rounded hover:bg-slate-800 transition">➕ Add Package</a>
        <a href="add_offer.php" class="block p-3 rounded hover:bg-slate-800 transition">🔥 Add New Offer</a>
        <a href="gallery.php" class="block p-3 rounded hover:bg-slate-800 transition">🖼️ Manage Gallery</a>
        <a href="manage_tours.php" class="block p-3 rounded hover:bg-slate-800 transition">🎫 Manage Tours</a>
        
        <div class="pt-4 mt-4 border-t border-slate-700">
            <a href="bookings.php" class="block p-3 rounded hover:bg-slate-800 transition">📅 Bookings</a>
            <a href="customers.php" class="block p-3 rounded hover:bg-slate-800 transition">👥 Customers</a>
        </div>
        
        <div class="mt-10 pt-5 border-t border-slate-700">
            <a href="logout.php" class="block p-3 rounded text-red-400 hover:bg-red-900/20 transition">🚪 Logout</a>
        </div>
    </nav>
</div>

<div id="overlay" class="fixed inset-0 bg-black opacity-50 z-30 hidden md:hidden"></div>

<script>
    const menuBtn = document.getElementById('menu-btn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
</script>