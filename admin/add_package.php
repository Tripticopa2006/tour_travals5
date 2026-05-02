<?php
include('db.php');
session_start();

// Admin Session Check
if (!isset($_SESSION['admin'])) { 
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['submit'])) {
    $p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $p_location = mysqli_real_escape_string($conn, $_POST['p_location']);
    $p_price = $_POST['p_price'];
    $p_transport = mysqli_real_escape_string($conn, $_POST['p_transport']);
    $p_hotel = mysqli_real_escape_string($conn, $_POST['p_hotel']); 
    $p_description = mysqli_real_escape_string($conn, $_POST['p_description']);

    $target_dir = "uploads/";
    $video_dir = "uploads/videos/";
    $timestamp = time();

    // 1. Package Main Image
    $p_image = $_FILES['p_image']['name'];
    $final_p_image = $timestamp . "_" . basename($p_image);

    // 2. Transport Image
    $t_image = $_FILES['p_transport_image']['name'];
    $final_t_image = $timestamp . "_" . basename($t_image);

    // 3. Hotel Image
    $h_image = $_FILES['p_hotel_image']['name'];
    $final_h_image = ($p_hotel == "Yes" && !empty($h_image)) ? $timestamp . "_" . basename($h_image) : "";

    // 4. Video Upload Logic
    $video_name = $_FILES['p_video']['name'];
    $final_video_name = !empty($video_name) ? "VID_" . $timestamp . "_" . basename($video_name) : "";

    // SQL Insert (Make sure your DB has 'p_video' column)
    $sql = "INSERT INTO packages (p_name, p_location, p_price, p_transport, p_transport_image, p_hotel, p_hotel_image, p_description, p_image, p_video) 
            VALUES ('$p_name', '$p_location', '$p_price', '$p_transport', '$final_t_image', '$p_hotel', '$final_h_image', '$p_description', '$final_p_image', '$final_video_name')";

    if (mysqli_query($conn, $sql)) {
        move_uploaded_file($_FILES['p_image']['tmp_name'], $target_dir . $final_p_image);
        move_uploaded_file($_FILES['p_transport_image']['tmp_name'], $target_dir . $final_t_image);
        
        if ($p_hotel == "Yes" && !empty($h_image)) {
            move_uploaded_file($_FILES['p_hotel_image']['tmp_name'], $target_dir . $final_h_image);
        }
        
        if (!empty($final_video_name)) {
            move_uploaded_file($_FILES['p_video']['tmp_name'], $video_dir . $final_video_name);
        }
        
        $message = "<div class='bg-green-100 text-green-700 p-4 rounded-xl mb-6 border border-green-200 shadow-sm animate__animated animate__fadeIn'>✅ Package added successfully!</div>";
    } else {
        $message = "<div class='bg-red-100 text-red-700 p-4 rounded-xl mb-6 border border-red-200 shadow-sm'>❌ Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tour Package | TravelMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-slate-50 font-sans">

    <?php include('sidebar.php'); ?>

    <main class="ml-0 md:ml-64 min-h-screen p-4 md:p-8 transition-all duration-300">
        
        <div class="max-w-4xl mx-auto bg-white p-6 md:p-10 rounded-3xl shadow-xl border-t-8 border-blue-600 mt-12 md:mt-0">
            <div class="flex items-center justify-between mb-8 border-b pb-5">
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">🚀 Create New Package</h2>
                <a href="manage_packages.php" class="text-blue-600 hover:underline text-sm font-bold">Back to List</a>
            </div>
            
            <?php echo $message; ?>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-8">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-slate-700 font-bold mb-2 text-sm">Package Name</label>
                        <input type="text" name="p_name" placeholder="e.g. Manali Adventure" required class="w-full p-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white outline-none transition">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-2 text-sm">Location</label>
                        <input type="text" name="p_location" placeholder="Himachal Pradesh" required class="w-full p-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white outline-none transition">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-2 text-sm">Price (₹)</label>
                        <input type="number" name="p_price" placeholder="9999" required class="w-full p-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100 space-y-4">
                        <label class="block text-blue-800 font-black uppercase text-xs tracking-widest">🚌 Transport Details</label>
                        <select name="p_transport" required class="w-full p-3 border-2 border-white rounded-xl outline-none focus:border-blue-400 shadow-sm">
                            <option value="Bus">Luxury Bus</option>
                            <option value="Car">Private Car</option>
                            <option value="Bike">Adventure Bike</option>
                            <option value="Van">Traveler Van</option>
                        </select>
                        <div class="bg-white p-4 rounded-2xl border border-blue-100">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-2">Transport Image</p>
                            <input type="file" name="p_transport_image" accept="image/*" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    <div class="bg-indigo-50/50 p-6 rounded-3xl border border-indigo-100 space-y-4">
                        <label class="block text-indigo-800 font-black uppercase text-xs tracking-widest">🏨 Accommodation</label>
                        <select name="p_hotel" id="hotel_select" required class="w-full p-3 border-2 border-white rounded-xl outline-none focus:border-indigo-400 shadow-sm">
                            <option value="Yes">Included (Yes)</option>
                            <option value="No">Not Included (No)</option>
                        </select>
                        <div id="hotel_img_div" class="bg-white p-4 rounded-2xl border border-indigo-100 transition-all">
                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-2">Hotel Photo</p>
                            <input type="file" name="p_hotel_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <label class="block text-slate-700 font-bold mb-2 text-sm">Trip Highlights</label>
                        <textarea name="p_description" rows="6" placeholder="✨ What's included?&#10;✅ Dinner&#10;✅ Sightseeing" required class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 outline-none transition resize-none"></textarea>
                    </div>
                    <div class="space-y-4">
                        <label class="block text-slate-700 font-bold mb-2 text-sm">Promotional Video</label>
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center bg-slate-50">
                            <input type="file" name="p_video" accept="video/*" class="text-xs w-full">
                            <p class="text-[10px] text-slate-400 mt-2">Optional: MP4/MKV format</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 p-8 rounded-3xl text-center shadow-inner">
                    <label class="block text-white font-bold mb-4">📸 Main Package Banner</label>
                    <input type="file" name="p_image" accept="image/*" required class="text-slate-400 text-sm">
                </div>

                <button type="submit" name="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-blue-200 transition duration-300 transform hover:-translate-y-1 uppercase tracking-widest text-lg">
                    🚢 Save & Publish Package
                </button>
            </form>
        </div>
    </main>

    <script>
        const hotelSelect = document.getElementById('hotel_select');
        const hotelImgDiv = document.getElementById('hotel_img_div');

        hotelSelect.addEventListener('change', function() {
            if (this.value === 'No') {
                hotelImgDiv.classList.add('opacity-30', 'grayscale');
                hotelImgDiv.style.pointerEvents = 'none';
            } else {
                hotelImgDiv.classList.remove('opacity-30', 'grayscale');
                hotelImgDiv.style.pointerEvents = 'auto';
            }
        });
    </script>

</body>
</html>