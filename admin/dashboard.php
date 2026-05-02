<?php 
include('db.php'); 
$total_bookings = 0; // Backup values if DB connection fails
$total_packages = 0;

// Proper error handling for queries
$res_bookings = mysqli_query($conn, "SELECT id FROM bookings");
if($res_bookings) $total_bookings = mysqli_num_rows($res_bookings);

$res_packages = mysqli_query($conn, "SELECT id FROM packages");
if($res_packages) $total_packages = mysqli_num_rows($res_packages);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌍 Tour & Travels Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <?php include('sidebar.php'); ?>

    <div class="ml-0 md:ml-64 p-4 md:p-8 transition-all duration-300">
        
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 mt-12 md:mt-0 gap-4">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Admin Overview</h1>
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border">
                <span class="text-gray-600 text-sm md:text-base">Welcome, <strong>Admin</strong></span>
            </div>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-blue-500">
                <h3 class="text-gray-500 font-medium text-sm uppercase tracking-wider">Total Bookings</h3>
                <p class="text-3xl font-bold mt-2"><?php echo $total_bookings; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-green-500">
                <h3 class="text-gray-500 font-medium text-sm uppercase tracking-wider">Packages Active</h3>
                <p class="text-3xl font-bold mt-2"><?php echo $total_packages; ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-purple-500">
                <h3 class="text-gray-500 font-medium text-sm uppercase tracking-wider">New Inquiries</h3>
                <p class="text-3xl font-bold mt-2">15</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">Recent Customer Bookings</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-4 font-semibold text-gray-600">ID</th>
                            <th class="p-4 font-semibold text-gray-600">Customer Name</th>
                            <th class="p-4 font-semibold text-gray-600">Package</th>
                            <th class="p-4 font-semibold text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        $sql = "SELECT bookings.id, users.full_name AS customer_name, packages.p_name AS package_name, bookings.status 
                                FROM bookings 
                                JOIN users ON bookings.user_id = users.id 
                                JOIN packages ON bookings.package_id = packages.id 
                                ORDER BY bookings.id DESC LIMIT 5";
                        
                        $res = mysqli_query($conn, $sql);

                        if($res && mysqli_num_rows($res) > 0) {
                            while($row = mysqli_fetch_assoc($res)) {
                                echo "<tr>
                                    <td class='p-4 whitespace-nowrap text-sm'>#{$row['id']}</td>
                                    <td class='p-4 whitespace-nowrap font-medium'>{$row['customer_name']}</td>
                                    <td class='p-4 whitespace-nowrap text-sm'>{$row['package_name']}</td>
                                    <td class='p-4 whitespace-nowrap'>
                                        <span class='px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase'>{$row['status']}</span>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='p-4 text-center text-gray-500'>No bookings found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>