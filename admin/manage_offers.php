<?php
// ... Header and Session check (same as manage_packages.php) ...
include('db.php');
session_start();

$query = "SELECT offers.*, packages.p_name, packages.p_price, packages.p_image 
          FROM offers 
          JOIN packages ON offers.package_id = packages.id 
          ORDER BY offers.id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="overflow-x-auto bg-white rounded-2xl border border-slate-200">
    <table class="w-full text-left">
        <thead class="bg-slate-900 text-white">
            <tr>
                <th class="p-4">Package</th>
                <th class="p-4">Offer Name</th>
                <th class="p-4">Original Price</th>
                <th class="p-4">Discounted Price</th>
                <th class="p-4">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php while($row = mysqli_fetch_assoc($result)) { 
                $discount_amount = ($row['p_price'] * $row['discount_percentage']) / 100;
                $final_price = $row['p_price'] - $discount_amount;
            ?>
            <tr>
                <td class="p-4 font-bold"><?php echo $row['p_name']; ?></td>
                <td class="p-4 text-orange-600 font-medium"><?php echo $row['offer_title']; ?> (<?php echo $row['discount_percentage']; ?>% Off)</td>
                <td class="p-4 text-slate-400 line-through">₹<?php echo $row['p_price']; ?></td>
                <td class="p-4 text-green-600 font-extrabold">₹<?php echo $final_price; ?></td>
                <td class="p-4">
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">Active</span>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>