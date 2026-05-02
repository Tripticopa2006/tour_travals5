<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Database Connection
if (file_exists('admin/db.php')) {
    include('admin/db.php');
} else {
    die("Error: db.php file nahi mili!");
}

// 2. ID check karna (URL se)
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Database se offer ki details nikalna
    $query = "SELECT * FROM offers WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $offer = mysqli_fetch_assoc($result);
        // Ab humare paas offer ka data aa gaya hai
    } else {
        die("<div style='text-align:center; padding:50px;'><h1>Oops! 🌿</h1><p>Ye package ab available nahi hai.</p><a href='offers.php'>Wapas jayein</a></div>");
    }
} else {
    die("Error: Koi ID nahi mili!");
}

// 3. Header Include
if (file_exists('header.php')) {
    include "header.php";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking: <?php echo $offer['offer_name']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

    <div class="max-w-4xl mx-auto my-10 bg-white shadow-2xl rounded-3xl overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/2">
                <img src="admin/uploads/offers/<?php echo $offer['offer_image']; ?>" 
                     class="h-full w-full object-cover" 
                     onerror="this.src='https://images.unsplash.com/photo-1472396961693-142e6e269027?auto=format&fit=crop&w=600'">
            </div>

            <div class="md:w-1/2 p-8">
                <span class="bg-emerald-100 text-emerald-600 px-3 py-1 rounded-full text-xs font-bold uppercase">
                    Special Offer: <?php echo $offer['discount_pct']; ?>% OFF
                </span>
                
                <h1 class="text-3xl font-black text-slate-800 mt-4"><?php echo $offer['offer_name']; ?></h1>
                <p class="text-slate-500 mt-2 italic">Promo Code: <b class="text-emerald-500"><?php echo strtoupper($offer['offer_code']); ?></b></p>
                
                <hr class="my-6">

                <form action="payment.php" method="POST" class="space-y-4">
                    <input type="hidden" name="offer_id" value="<?php echo $offer['id']; ?>">
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700">Aapka Naam</label>
                        <input type="text" name="user_name" required class="w-full border-2 border-slate-100 p-3 rounded-xl focus:border-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700">Phone Number</label>
                        <input type="tel" name="user_phone" required class="w-full border-2 border-slate-100 p-3 rounded-xl focus:border-emerald-500 outline-none">
                    </div>

                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-black py-4 rounded-2xl transition-all shadow-lg shadow-emerald-200">
                        CONFIRM MY BOOKING ✈️
                    </button>
                </form>
            </div>
        </div>
    </div>

<?php 
if (file_exists('footer.php')) {
    include "footer.php"; 
}
?>
</body>
</html>