<?php
include('db.php'); 
session_start();

if (!isset($_SESSION['admin'])) { 
    header("Location: login.php");
    exit();
}

// 1. Update Logic (Modal Submit)
if(isset($_POST['update_offer'])) {
    $id = intval($_POST['offer_id']);
    $offer_name = mysqli_real_escape_string($conn, $_POST['offer_name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $discount = mysqli_real_escape_string($conn, $_POST['discount']);

    $update_query = "UPDATE offers SET offer_name='$offer_name', location='$location', price='$price', discount_percentage='$discount' WHERE id=$id";
    
    if(mysqli_query($conn, $update_query)) {
        echo "<script>alert('Offer Updated!'); window.location.href='view_offers.php';</script>";
    }
}

// Status Toggle Logic
if(isset($_GET['type']) && $_GET['type'] == 'status'){
    $id = intval($_GET['id']);
    $operation = mysqli_real_escape_string($conn, $_GET['operation']);
    $status = ($operation == 'active') ? '1' : '0';
    mysqli_query($conn, "UPDATE offers SET status='$status' WHERE id='$id'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Offers | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .modal { transition: opacity 0.25s ease; }
        body.modal-active { overflow-x: hidden; overflow-y: visible !important; }
    </style>
</head>
<body class="bg-[#f8fafc]">

    <?php include('sidebar.php'); ?>

    <main class="lg:ml-64 min-h-screen p-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-slate-800">Live <span class="text-blue-600">Offers</span></h1>
                <a href="add_offer.php" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg">New Offer +</a>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border p-6">
                <table id="offersTable" class="w-full">
                    <thead>
                        <tr class="text-slate-400 text-xs uppercase text-left">
                            <th class="p-4">Banner</th>
                            <th class="p-4">Offer Name</th>
                            <th class="p-4">Price</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM offers ORDER BY id DESC");
                        while($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr class="border-t hover:bg-slate-50">
                            <td class="p-4">
                                <img src="uploads/offers/<?php echo $row['image']; ?>" class="w-16 h-12 rounded-lg object-cover">
                            </td>
                            <td class="p-4">
                                <p class="font-bold text-slate-800"><?php echo $row['offer_name']; ?></p>
                                <p class="text-xs text-slate-400"><?php echo $row['location']; ?></p>
                            </td>
                            <td class="p-4 font-bold text-blue-600">₹<?php echo $row['price']; ?></td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold <?php echo $row['status']==1 ? 'bg-green-100 text-green-600':'bg-red-100 text-red-600'; ?>">
                                    <?php echo $row['status']==1 ? 'ACTIVE':'INACTIVE'; ?>
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <button onclick="openEditModal(<?php echo $row['id']; ?>)" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="confirmDelete(<?php echo $row['id']; ?>)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="editModal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-slate-900 opacity-50"></div>
        
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-3xl shadow-2xl z-50 overflow-y-auto">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-slate-800">Edit Offer</h2>
                    <button onclick="toggleModal()" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times text-xl"></i></button>
                </div>

                <form method="POST">
                    <input type="hidden" name="offer_id" id="edit_id">
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-bold uppercase text-slate-500">Offer Name</label>
                            <input type="text" name="offer_name" id="edit_name" class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="text-xs font-bold uppercase text-slate-500">Location</label>
                            <input type="text" name="location" id="edit_location" class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:border-blue-500">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold uppercase text-slate-500">Price</label>
                                <input type="number" name="price" id="edit_price" class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase text-slate-500">Discount %</label>
                                <input type="number" name="discount" id="edit_discount" class="w-full p-3 bg-slate-50 border rounded-xl outline-none focus:border-blue-500">
                            </div>
                        </div>
                        <button type="submit" name="update_offer" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-200 mt-4 hover:bg-blue-700">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleModal() {
            const modal = document.querySelector('.modal');
            modal.classList.toggle('opacity-0');
            modal.classList.toggle('pointer-events-none');
            document.body.classList.toggle('modal-active');
        }

        function openEditModal(id) {
            // Fetch data using AJAX
            $.ajax({
                url: 'fetch_offer.php',
                type: 'POST',
                data: {id: id},
                success: function(response) {
                    const data = JSON.parse(response);
                    $('#edit_id').val(data.id);
                    $('#edit_name').val(data.offer_name);
                    $('#edit_location').val(data.location);
                    $('#edit_price').val(data.price);
                    $('#edit_discount').val(data.discount_percentage);
                    toggleModal(); // Open Modal
                }
            });
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Delete Offer?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'add_offer.php?delete=' + id;
                }
            });
        }
    </script>
</body>
</html>