<?php
session_start();
include "header.php"; 
error_reporting(E_ALL); 
ini_set('display_errors', 1);

// 1. Database Connection check
if (file_exists('admin/db.php')) {
    include('admin/db.php');
} else {
    die("Error: db.php file admin folder mein nahi mili!");
}

if (!isset($conn)) {
    die("Error: Database connection variable (\$conn) is not defined in admin/db.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
    <title>🌍 Our Packages - Tour & Travels</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                              url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
        }

        /* Premium Compact Card */
        .offer-card { 
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            background: rgba(255, 255, 255, 0.1); /* Glass effect */
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 2.5rem;
            max-width: 310px;
            margin: auto;
            position: relative;
            overflow: hidden;
        }
        
        .offer-card:hover { 
            transform: translateY(-15px); 
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 30px 60px rgba(0,0,0,0.5);
        }

        .offer-card:hover h3 { color: #1e293b; }
        .offer-card h3 { color: white; transition: 0.3s; }

        .discount-badge {
            background: linear-gradient(45deg, #10b981, #059669);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .btn-shimmer {
            position: relative;
            overflow: hidden;
            background: #1e293b;
            color: white;
            transition: 0.3s;
        }
        .btn-shimmer::before {
            content: '';
            position: absolute; top: 0; left: -100%; width: 50%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: 0.5s;
        }
        .btn-shimmer:hover::before { left: 150%; }
        .btn-shimmer:hover { background: #059669; transform: scale(1.05); }

        .text-shadow { text-shadow: 2px 2px 10px rgba(0,0,0,0.7); }
        .img-container { overflow: hidden; height: 170px; border-radius: 2.5rem 2.5rem 1rem 1rem; margin: 8px; }
        .img-container img { transition: 1s ease; }
        .offer-card:hover .img-container img { transform: scale(1.2); filter: brightness(1.1); }
    </style>
</head>
<body class="font-sans">

    <header class="py-16 px-4 text-center">
        <h1 class="text-5xl md:text-6xl font-black text-white mb-3 animate__animated animate__pulse animate__infinite text-shadow tracking-tighter">
            Nature <span class="text-emerald-400">Jackpot</span> 🌲
        </h1>
        <p class="text-emerald-100 text-lg max-w-lg mx-auto text-shadow font-semibold bg-black/30 py-2 rounded-full backdrop-blur-md px-6">
            Pick a card, grab a deal, start the journey!
        </p>
    </header>

    <div class="max-w-7xl mx-auto px-6 pb-24">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            
            <?php
            // Offers fetch kar rahe hain
            $query = "SELECT * FROM offers ORDER BY id DESC"; 
            $res = mysqli_query($conn, $query);

            if($res && mysqli_num_rows($res) > 0) {
                while($row = mysqli_fetch_assoc($res)) {
                    // ID pakad li database se
                    $offer_id = $row['id']; 
                    $img      = !empty($row['offer_image']) ? $row['offer_image'] : '';
                    $name     = !empty($row['offer_name']) ? $row['offer_name'] : 'Scenic Escape';
                    $discount = !empty($row['discount_pct']) ? $row['discount_pct'] : '20';
                    $code     = !empty($row['offer_code']) ? $row['offer_code'] : 'nature';
            ?>
            
            <div class="offer-card animate__animated animate__zoomIn">
                <div class="img-container relative">
                    <img src="admin/uploads/offers/<?php echo $img; ?>" 
                         class="w-full h-full object-cover" 
                         onerror="this.src='https://images.unsplash.com/photo-1472396961693-142e6e269027?auto=format&fit=crop&w=600'">
                    
                    <div class="discount-badge absolute top-4 left-4 text-white px-4 py-1.5 rounded-full font-black text-xs shadow-2xl">
                        SAVE <?php echo $discount; ?>%
                    </div>
                </div>

                <div class="p-7">
                    <h3 class="text-xl font-black mb-4 truncate italic tracking-tight">
                        <?php echo htmlspecialchars($name); ?>
                    </h3>
                    
                    <div class="relative group cursor-pointer mb-6" onclick="copyCode('<?php echo $code; ?>')">
                        <div class="bg-white/10 group-hover:bg-emerald-50 border-2 border-dashed border-emerald-400/50 p-4 rounded-2xl transition-all flex items-center justify-between">
                            <div>
                                <p class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest leading-none mb-1">Promo Code</p>
                                <span class="text-xl font-black text-emerald-500 font-mono tracking-widest"><?php echo strtoupper($code); ?></span>
                            </div>
                            <div class="bg-emerald-500 text-white h-10 w-10 flex items-center justify-center rounded-xl shadow-lg group-hover:rotate-12 transition">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                        </div>
                    </div>

                    <a href="booking1_process.php?id=<?php echo $offer_id; ?>" class="btn-shimmer block w-full text-center py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl">
                        Claim Now <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                </div>
            </div>

            <?php 
                } 
            } else {
                echo "<div class='col-span-full text-center py-20 text-white font-bold bg-white/10 backdrop-blur rounded-[3rem]'>🌿 No active deals found!</div>";
            }
            ?>
        </div>
    </div>

    <div id="toast" class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-white text-emerald-600 border-2 border-emerald-500 px-12 py-5 rounded-3xl font-black shadow-2xl opacity-0 transition-all duration-500 z-50 pointer-events-none flex items-center gap-4">
        <div class="bg-emerald-100 h-10 w-10 flex items-center justify-center rounded-full">
            <i class="fas fa-check text-emerald-600"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 leading-none">Successful</p>
            <p class="text-lg">CODE COPIED!</p>
        </div>
    </div>

    <script>
        function copyCode(code) {
            navigator.clipboard.writeText(code);
            const toast = document.getElementById('toast');
            toast.style.opacity = '1';
            toast.style.transform = 'translate(-50%, -30px)';
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, 0px)';
            }, 2500);
        }
    </script>

<?php 
if (file_exists('footer.php')) {
    include "footer.php"; 
}
?>
</body>
</html>