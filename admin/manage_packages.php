<?php
include('db.php');
session_start();

// Admin Session Check
if (!isset($_SESSION['admin'])) { 
    header("Location: login.php");
    exit();
}

$message = "";

// Delete Logic
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    
    $res = mysqli_query($conn, "SELECT p_image FROM packages WHERE id='$id'");
    $row = mysqli_fetch_assoc($res);
    if($row && !empty($row['p_image']) && file_exists("uploads/".$row['p_image'])) {
        unlink("uploads/".$row['p_image']);
    }

    $sql = "DELETE FROM packages WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        $message = "<div class='bg-green-100 text-green-700 p-4 rounded-xl mb-6 border border-green-200 animate__animated animate__fadeIn'>✅ Package deleted successfully!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Packages | TravelMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-slate-50 font-sans">

    <?php include('sidebar.php'); ?>

    <main class="ml-0 md:ml-64 min-h-screen p-4 md:p-8 transition-all duration-300">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 mt-12 md:mt-0 gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">🗺️ Manage Packages</h2>
                <p class="text-slate-500 text-sm"></p>
            </div>
            <a href="add_package.php" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-200 transition transform active:scale-95 text-sm md:text-base">
                <span class="mr-2">➕</span> Create New Package
            </a>
        </div>

        <?php echo $message; ?>

        <div class="mb-6">
            <div class="relative w-full md:w-1/3">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">🔍</span>
                <input type="text" placeholder="Search packages..." class="w-full pl-10 p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none shadow-sm transition">
            </div>
        </div>

        <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-900 text-white">
                    <tr>
                        <th class="p-4 font-semibold uppercase text-xs">Image</th>
                        <th class="p-4 font-semibold uppercase text-xs">Package Name</th>
                        <th class="p-4 font-semibold uppercase text-xs">Location</th>
                        <th class="p-4 font-semibold uppercase text-xs">Price</th>
                        <th class="p-4 font-semibold uppercase text-xs text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php 
                    $query = mysqli_query($conn, "SELECT * FROM packages ORDER BY id DESC");
                    if(mysqli_num_rows($query) > 0) {
                        while($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4 text-center">
                            <img src="uploads/<?php echo $row['p_image']; ?>" class="w-16 h-12 object-cover rounded-lg shadow-sm border border-slate-200" alt="pkg">
                        </td>
                        <td class="p-4 font-bold text-slate-700"><?php echo $row['p_name']; ?></td>
                        <td class="p-4 text-slate-500 text-sm">📍 <?php echo $row['p_location']; ?></td>
                        <td class="p-4 text-blue-600 font-bold">₹<?php echo $row['p_price']; ?></td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="edit_package.php?id=<?php echo $row['id']; ?>" class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition" title="Edit">
                                    ✏️
                                </a>
                                <a href="manage_packages.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this package?')" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Delete">
                                    🗑️
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='5' class='p-10 text-center text-slate-400 font-medium'>No packages found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 gap-4 md:hidden">
            <?php 
            if(mysqli_num_rows($query) > 0) {
                // Reset pointer for mobile loop
                mysqli_data_seek($query, 0); 
                while($row = mysqli_fetch_assoc($query)) {
            ?>
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 flex flex-col gap-3 animate__animated animate__fadeIn">
                <div class="flex items-center gap-4">
                    <img src="uploads/<?php echo $row['p_image']; ?>" class="w-20 h-20 object-cover rounded-xl border border-slate-100 shadow-sm" alt="pkg">
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-800 leading-tight"><?php echo $row['p_name']; ?></h4>
                        <p class="text-xs text-slate-500 mt-1 italic">📍 <?php echo $row['p_location']; ?></p>
                        <p class="text-blue-600 font-bold mt-1">₹<?php echo $row['p_price']; ?></p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-3 border-t border-slate-50">
                    <a href="edit_package.php?id=<?php echo $row['id']; ?>" class="flex items-center justify-center gap-2 bg-yellow-50 text-yellow-600 py-2.5 rounded-xl font-bold text-sm active:bg-yellow-100 transition">
                        ✏️ Edit
                    </a>
                    <a href="manage_packages.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Confirm delete?')" class="flex items-center justify-center gap-2 bg-red-50 text-red-600 py-2.5 rounded-xl font-bold text-sm active:bg-red-100 transition">
                        🗑️ Delete
                    </a>
                </div>
            </div>
            <?php 
                }
            } else {
                echo "<div class='p-10 text-center text-slate-400 bg-white rounded-2xl border border-dashed border-slate-300'>Koi packages nahi mile.</div>";
            }
            ?>
        </div>

    </main>

</body>
</html>