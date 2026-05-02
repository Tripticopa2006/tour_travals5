<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); 

// --- Database Connection ---
$db_name = "tour_travals"; 
$conn = mysqli_connect("localhost", "root", "", $db_name);

if (!$conn) {
    die("Connection Error: " . mysqli_connect_error());
}

// Admin Session Check (Added for security)
if (!isset($_SESSION['admin'])) { 
    header("Location: login.php");
    exit();
}

// --- Image Upload Logic ---
if (isset($_POST['upload'])) {
    if (!empty($_POST['package_id']) && !empty($_FILES['image']['name'])) {
        $target_dir = "images/gallery/"; 
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }

        $package_id = intval($_POST['package_id']);
        $file_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO gallery (package_id, image_path) VALUES ($package_id, '$target_file')";
                if(mysqli_query($conn, $sql)) {
                    $_SESSION['success_msg'] = "✅ Image Uploaded Successfully!";
                    header("Location: gallery.php"); 
                    exit();
                }
            }
        } else {
            $_SESSION['error_msg'] = "❌ Selected file is not an image!";
            header("Location: gallery.php");
            exit();
        }
    }
}

// --- Delete Logic ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $res = mysqli_query($conn, "SELECT image_path FROM gallery WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    if($row) { 
        if(file_exists($row['image_path'])) { unlink($row['image_path']); }
        mysqli_query($conn, "DELETE FROM gallery WHERE id=$id"); 
    }
    header("Location: gallery.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-slate-50 font-sans text-slate-900">
    
    <?php include 'sidebar.php'; ?>

    <main class="ml-0 md:ml-64 p-4 md:p-8 min-h-screen transition-all duration-300">
        
        <div class="mt-12 md:mt-0 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-4xl font-black text-slate-800 tracking-tight">🖼️ Media Gallery</h1>
                <p class="text-slate-500 text-sm">Organize and manage photos for each tour package.</p>
            </div>
        </div>
        
        <?php if(isset($_SESSION['success_msg'])): ?>
            <div class="bg-emerald-500 text-white p-4 rounded-2xl mb-6 shadow-lg animate__animated animate__fadeInDown flex items-center gap-3 font-bold">
                <span><?php echo $_SESSION['success_msg']; ?></span>
            </div>
            <?php unset($_SESSION['success_msg']); ?>
        <?php endif; ?>

        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200 mb-10">
            <h3 class="text-lg font-bold mb-4 text-slate-700 flex items-center gap-2">
                <span class="p-2 bg-blue-100 text-blue-600 rounded-lg"><i class="fas fa-plus"></i></span>
                Add New Photo
            </h3>
            <form action="gallery.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                <div class="md:col-span-4 space-y-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ps-1">Assign to Tour</label>
                    <select name="package_id" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl outline-none focus:border-blue-500 focus:bg-white transition" required>
                        <option value="">-- Select Tour Package --</option>
                        <?php
                        $packages = mysqli_query($conn, "SELECT id, p_name FROM packages ORDER BY p_name ASC");
                        while($p = mysqli_fetch_assoc($packages)) {
                            echo "<option value='{$p['id']}'>".ucwords($p['p_name'])."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="md:col-span-5 space-y-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest ps-1">Select Image</label>
                    <div class="relative group">
                        <input type="file" name="image" accept="image/*" class="w-full p-3 border-2 border-dashed border-slate-200 rounded-2xl cursor-pointer hover:border-blue-400 transition text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700" required>
                    </div>
                </div>
                <div class="md:col-span-3">
                    <button name="upload" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 px-6 rounded-2xl transition shadow-xl shadow-blue-100 transform active:scale-95">
                        🚀 Start Upload
                    </button>
                </div>
            </form>
        </div>

        <?php
        $package_query = mysqli_query($conn, "SELECT DISTINCT packages.id, packages.p_name 
                                             FROM packages 
                                             INNER JOIN gallery ON packages.id = gallery.package_id 
                                             ORDER BY packages.p_name ASC");

        if(mysqli_num_rows($package_query) > 0):
            while($package = mysqli_fetch_assoc($package_query)):
                $pid = $package['id'];
                $pname = ucwords($package['p_name']);
        ?>
            
            <div class="mb-12">
                <div class="flex items-center gap-4 mb-6">
                    <div class="bg-white px-5 py-2 rounded-2xl shadow-sm border border-slate-200">
                        <h2 class="text-sm md:text-lg font-black text-slate-700 uppercase tracking-wider">
                            📍 <?php echo $pname; ?>
                        </h2>
                    </div>
                    <div class="h-px bg-slate-200 flex-grow hidden sm:block"></div>
                    <span class="bg-slate-200 text-slate-600 text-[10px] font-black px-4 py-1.5 rounded-full uppercase">
                        <?php 
                        $count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM gallery WHERE package_id=$pid");
                        $count = mysqli_fetch_assoc($count_res);
                        echo $count['total'] . " Photos";
                        ?>
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                    <?php
                    $img_res = mysqli_query($conn, "SELECT * FROM gallery WHERE package_id=$pid ORDER BY id DESC");
                    while($img = mysqli_fetch_assoc($img_res)):
                    ?>
                        <div class='group relative bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 transition hover:shadow-2xl hover:-translate-y-1 animate__animated animate__zoomIn'>
                            <div class="aspect-square overflow-hidden">
                                <img src='<?php echo $img['image_path']; ?>' class='h-full w-full object-cover group-hover:scale-110 transition duration-700'>
                            </div>
                            
                            <a href='gallery.php?delete=<?php echo $img['id']; ?>' 
                               onclick="return confirm('Do you want to delete this photo permanently?')"
                               class="absolute top-3 right-3 bg-white/90 backdrop-blur-md text-red-600 p-2.5 rounded-xl shadow-lg md:opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-red-600 hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

        <?php 
            endwhile; 
        else: ?>
            <div class='flex flex-col items-center justify-center py-20 bg-white rounded-[2rem] border-2 border-dashed border-slate-200 text-center px-4'>
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-4xl">📸</div>
                <h3 class="text-xl font-bold text-slate-800">No Gallery Photos Yet</h3>
                <p class='text-slate-400 max-w-xs mt-2'>Select a tour package above and upload images to see them organized here.</p>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>