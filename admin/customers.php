<?php
include('db.php');
session_start();

// Security Check: Sirf admin hi dekh sake
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// User delete karne ka logic (Optional)
if (isset($_GET['delete_id'])) {
    $u_id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM users WHERE id = $u_id");
    header("Location: customers.php?msg=deleted");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🌍 Tour & Travals</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <?php include('sidebar.php'); ?>

    <div class="ml-64 p-8 w-full">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Registered Customers</h2>
                <p class="text-gray-500"></p>
            </div>
            <div class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
                Total Users: 
                <?php 
                $count_res = mysqli_query($conn, "SELECT COUNT(id) as total FROM users");
                $count_data = mysqli_fetch_assoc($count_res);
                echo $count_data['total'];
                ?>
            </div>
        </div>

        <?php if(isset($_GET['msg'])): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">User record removed successfully!</div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-900 text-white">
                    <tr>
                        <th class="p-4">ID</th>
                        <th class="p-4">Full Name</th>
                        <th class="p-4">Email Address</th>
                        <th class="p-4">Phone Number</th>
                        <th class="p-4">Registration Date</th>
                        <th class="p-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
                    if(mysqli_num_rows($res) > 0) {
                        while($user = mysqli_fetch_assoc($res)) {
                    ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-gray-500">#<?php echo $user['id']; ?></td>
                        <td class="p-4 font-semibold text-gray-800">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3 font-bold">
                                    <?php echo substr($user['full_name'], 0, 1); ?>
                                </div>
                                <?php echo $user['full_name']; ?>
                            </div>
                        </td>
                        <td class="p-4 text-gray-600"><?php echo $user['email']; ?></td>
                        <td class="p-4 text-gray-600"><?php echo $user['phone']; ?></td>
                        <td class="p-4 text-sm text-gray-500">
                            <?php echo date('d M, Y', strtotime($user['created_at'])); ?>
                        </td>
                        <td class="p-4 text-center">
                            <a href="customers.php?delete_id=<?php echo $user['id']; ?>" 
                               onclick="return confirm('Kya aap is user ko hatana chahte hain?')" 
                               class="text-red-500 hover:text-red-700 font-medium underline">
                               Remove
                            </a>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='6' class='p-10 text-center text-gray-400'>No customers found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>