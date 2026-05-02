<?php
include('db.php');
session_start();

if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }

$message = "";

if (isset($_POST['add_offer'])) {
    $package_id = $_POST['package_id'];
    $offer_title = mysqli_real_escape_string($conn, $_POST['offer_title']);
    $discount = $_POST['discount'];
    $expiry = $_POST['expiry'];

    $sql = "INSERT INTO offers (package_id, offer_title, discount_percentage, expiry_date) 
            VALUES ('$package_id', '$offer_title', '$discount', '$expiry')";
    
    if (mysqli_query($conn, $sql)) {
        $message = "<div class='bg-green-100 text-green-700 p-4 rounded-xl'>✅ Offer Created Successfully!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Special Offer | TravelMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
    <?php include('sidebar.php'); ?>
    <main class="ml-0 md:ml-64 p-8">
        <h2 class="text-3xl font-extrabold text-slate-800 mb-6">🏷️ Create New Offer</h2>
        <?php echo $message; ?>

        <form method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 max-w-2xl">
            <div class="mb-4">
                <label class="block text-slate-700 font-bold mb-2">Select Package</label>
                <select name="package_id" class="w-full p-3 rounded-xl border border-slate-200" required>
                    <?php
                    $pkgs = mysqli_query($conn, "SELECT id, p_name FROM packages");
                    while($p = mysqli_fetch_assoc($pkgs)) {
                        echo "<option value='".$p['id']."'>".$p['p_name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-slate-700 font-bold mb-2">Offer Title (e.g. Summer Sale)</label>
                <input type="text" name="offer_title" class="w-full p-3 rounded-xl border border-slate-200" required>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-slate-700 font-bold mb-2">Discount (%)</label>
                    <input type="number" name="discount" class="w-full p-3 rounded-xl border border-slate-200" placeholder="e.g. 20" required>
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-2">Expiry Date</label>
                    <input type="date" name="expiry" class="w-full p-3 rounded-xl border border-slate-200" required>
                </div>
            </div>
            <button type="submit" name="add_offer" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-blue-700 transition">Launch Offer 🚀</button>
        </form>
    </main>
</body>
</html>