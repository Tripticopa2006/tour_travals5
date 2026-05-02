<?php
include('db.php');
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $res = mysqli_query($conn, "SELECT * FROM packages WHERE id=$id");
    $data = mysqli_fetch_assoc($res);
    
    if (!$data) {
        header("Location: manage_packages.php");
        exit();
    }
} else {
    header("Location: manage_packages.php");
    exit();
}

$update_success = false;

if (isset($_POST['update'])) {
    $p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $p_location = mysqli_real_escape_string($conn, $_POST['p_location']);
    $p_price = $_POST['p_price'];
    $p_transport = mysqli_real_escape_string($conn, $_POST['p_transport']);
    $p_hotel = mysqli_real_escape_string($conn, $_POST['p_hotel']);
    $p_description = mysqli_real_escape_string($conn, $_POST['p_description']);
    $timestamp = time();

    // 1. Main Banner Image Handling
    if ($_FILES['p_image']['name'] != "") {
        $p_image = $timestamp . "_" . basename($_FILES['p_image']['name']);
        move_uploaded_file($_FILES['p_image']['tmp_name'], "uploads/" . $p_image);
    } else {
        $p_image = $data['p_image'];
    }

    // 2. Transport Image Handling
    if ($_FILES['p_transport_image']['name'] != "") {
        $t_image = $timestamp . "_" . basename($_FILES['p_transport_image']['name']);
        move_uploaded_file($_FILES['p_transport_image']['tmp_name'], "uploads/" . $t_image);
    } else {
        $t_image = $data['p_transport_image'];
    }

    // 3. Hotel Image Handling
    if ($_FILES['p_hotel_image']['name'] != "") {
        $h_image = $timestamp . "_" . basename($_FILES['p_hotel_image']['name']);
        move_uploaded_file($_FILES['p_hotel_image']['tmp_name'], "uploads/" . $h_image);
    } else {
        $h_image = $data['p_hotel_image'];
    }

    $update_query = "UPDATE packages SET 
                    p_name='$p_name', 
                    p_location='$p_location', 
                    p_price='$p_price', 
                    p_transport='$p_transport',
                    p_transport_image='$t_image',
                    p_hotel='$p_hotel',
                    p_hotel_image='$h_image',
                    p_description='$p_description', 
                    p_image='$p_image' 
                    WHERE id=$id";

    if (mysqli_query($conn, $update_query)) {
        $update_success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🌍 Edit Package - <?php echo $data['p_name']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex">

    <?php include('sidebar.php'); ?>

    <div class="ml-64 p-8 w-full">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-lg border-t-8 border-green-600">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Edit Tour Package Details</h2>
            
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-1">
                        <label class="block text-gray-700 font-bold">Package Name</label>
                        <input type="text" name="p_name" value="<?php echo $data['p_name']; ?>" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold">Location</label>
                        <input type="text" name="p_location" value="<?php echo $data['p_location']; ?>" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold">Price (₹)</label>
                        <input type="number" name="p_price" value="<?php echo $data['p_price']; ?>" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-green-50 p-6 rounded-2xl border border-green-100">
                    
                    <div class="space-y-3">
                        <label class="block text-green-900 font-bold uppercase text-sm">🚌 Transport Mode</label>
                        <select name="p_transport" required class="w-full p-2 border rounded-lg outline-none">
                            <option value="Bus" <?php if($data['p_transport'] == 'Bus') echo 'selected'; ?>>Luxury Bus</option>
                            <option value="Car" <?php if($data['p_transport'] == 'Car') echo 'selected'; ?>>Private Car</option>
                            <option value="Bike" <?php if($data['p_transport'] == 'Bike') echo 'selected'; ?>>Adventure Bike</option>
                            <option value="Van" <?php if($data['p_transport'] == 'Van') echo 'selected'; ?>>Traveler Van</option>
                        </select>
                        <div class="bg-white p-2 rounded-lg border">
                            <img src="uploads/<?php echo $data['p_transport_image']; ?>" class="w-20 h-12 object-cover rounded mb-2 border">
                            <span class="text-xs text-gray-500">Change Transport Photo:</span>
                            <input type="file" name="p_transport_image" accept="image/*" class="w-full mt-1 text-xs">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-green-900 font-bold uppercase text-sm">🏨 Hotel Included?</label>
                        <select name="p_hotel" id="hotel_select" required class="w-full p-2 border rounded-lg outline-none">
                            <option value="Yes" <?php if($data['p_hotel'] == 'Yes') echo 'selected'; ?>>Yes</option>
                            <option value="No" <?php if($data['p_hotel'] == 'No') echo 'selected'; ?>>No</option>
                        </select>
                        <div id="hotel_img_div" class="bg-white p-2 rounded-lg border">
                            <?php if(!empty($data['p_hotel_image'])): ?>
                                <img src="uploads/<?php echo $data['p_hotel_image']; ?>" class="w-20 h-12 object-cover rounded mb-2 border">
                            <?php endif; ?>
                            <span class="text-xs text-gray-500">Change Hotel Photo:</span>
                            <input type="file" name="p_hotel_image" accept="image/*" class="w-full mt-1 text-xs">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold">Description (WhatsApp Style)</label>
                    <textarea name="p_description" rows="5" required class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none"><?php echo $data['p_description']; ?></textarea>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <label class="block text-gray-700 font-bold mb-2">Main Banner Image</label>
                    <img src="uploads/<?php echo $data['p_image']; ?>" class="w-40 h-24 object-cover rounded mb-3 border shadow-sm">
                    <input type="file" name="p_image" accept="image/*" class="w-full p-2 border rounded-lg bg-white text-sm">
                </div>

                <div class="flex space-x-4 pt-4">
                    <button type="submit" name="update" class="flex-1 bg-green-600 text-white font-black py-4 rounded-xl hover:bg-green-700 shadow-lg transition uppercase tracking-widest">
                        💾 Update Package
                    </button>
                    <a href="manage_packages.php" class="px-8 bg-gray-500 text-white font-bold py-4 rounded-xl hover:bg-gray-600 transition flex items-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php if($update_success): ?>
    <script>
        Swal.fire({
            title: "Success!",
            text: "Package updated like a pro! 🚀",
            icon: "success",
            confirmButtonColor: "#16a34a"
        }).then(() => { window.location.href = "manage_packages.php"; });
    </script>
    <?php endif; ?>

    <script>
        // JS to toggle hotel image box
        const hotelSelect = document.getElementById('hotel_select');
        const hotelImgDiv = document.getElementById('hotel_img_div');
        hotelSelect.addEventListener('change', function() {
            hotelImgDiv.style.opacity = (this.value === 'No') ? '0.4' : '1';
        });
    </script>

</body>
</html>