<?php
session_start();
include "header.php"; 
include ('admin/db.php'); 

// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. Secure Query using mysqli_real_escape_string
$safe_user_id = mysqli_real_escape_string($conn, $user_id);

// Join bookings with packages to get the name and price
$query = "SELECT b.*, p.p_name, p.p_price 
          FROM bookings b
          INNER JOIN packages p ON b.package_id = p.id 
          WHERE b.user_id = '$safe_user_id' 
          ORDER BY b.id DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Tour & Travels</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  
    <style>
        body { 
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), 
                        url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff; 
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
        }

        .btn-back-dashboard {
            background: rgba(255, 255, 255, 0.1);
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            backdrop-filter: blur(10px);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-back-dashboard:hover {
            background: #fff;
            color: #000 !important;
            transform: translateX(-5px);
        }

        .booking-container {
            background: rgba(15, 23, 42, 0.6);
            border-radius: 30px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }

        h2 {
            font-weight: 800;
            letter-spacing: 1px;
            background: linear-gradient(to right, #ffffff, #00e5ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .table-dark { background: transparent !important; }
        .table-dark th { 
            color: #00e5ff; 
            font-size: 13px; 
            border-bottom: 1px solid rgba(0, 229, 255, 0.2);
            text-transform: uppercase;
            padding-bottom: 20px;
        }

        .status-badge {
            padding: 6px 15px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.5px;
            display: inline-block;
        }

        .btn-download { 
            background: #ffffff;
            color: #000 !important;
            font-weight: 700;
            border-radius: 12px;
            border: none;
            padding: 8px 18px;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-download:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(255,255,255,0.3);
        }

        /* Responsive Mobile View */
        @media (max-width: 768px) {
            .table-responsive thead { display: none; }
            .table-responsive tbody td {
                display: block;
                text-align: right;
                padding-left: 50%;
                position: relative;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }
            .table-responsive tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                font-weight: 700;
                color: #00e5ff;
            }
        }
    </style>
</head>
<body>

<div class="container mt-5 pt-4 pb-5">
    
    <div class="mb-4">
        <a href="user_dashboard.php" class="btn-back-dashboard">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold">MY ADVENTURES</h2>
        <p class="text-white-50">Manage and track all your travel bookings in one place.</p>
    </div>
    
    <div class="booking-container">
        <div class="table-responsive">
            <table class="table table-dark align-middle">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Package Name</th>
                        <th>Travel Dates</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($result && mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            // Fix: Convert status to lowercase for reliable checking
                            $raw_status = strtolower($row['status']); 
                            
                            // Determine Badge Style
                            $badgeClass = "bg-info text-dark"; // Default: Pending
                            if($raw_status == 'confirmed') {
                                $badgeClass = "bg-success";
                            } elseif($raw_status == 'cancelled') {
                                $badgeClass = "bg-danger";
                            }
                            
                            echo "<tr>";
                            echo "<td data-label='Booking ID' class='fw-bold' style='color:#00e5ff;'>#TRV-" . $row['id'] . "</td>";
                            echo "<td data-label='Package Name' class='fw-bold'>" . htmlspecialchars($row['p_name']) . "</td>";
                            
                            // Format Dates
                            $checkin = date('d M', strtotime($row['checkin_date']));
                            $checkout = date('d M, Y', strtotime($row['checkout_date']));
                            echo "<td data-label='Travel Dates'>$checkin - $checkout</td>";
                            
                            echo "<td data-label='Total Price' class='fw-bold text-white'>₹" . number_format($row['total_price']) . "</td>";
                            
                            // Display Status
                            echo "<td data-label='Status'><span class='status-badge $badgeClass'>" . strtoupper($row['status']) . "</span></td>";
                            
                            echo "<td data-label='Action' class='text-center'>";
                            
                            // Fix: The actual check for the button visibility
                            if($raw_status == 'confirmed') {
                                echo "<a href='ticket.php?id=" . $row['id'] . "' class='btn btn-sm btn-download'><i class='fas fa-file-arrow-down'></i> Ticket</a>";
                            } else {
                                echo "<span class='text-muted opacity-50 small'><i class='fas fa-lock me-1'></i> Locked</span>";
                            }
                            
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center py-5'>
                                <i class='fas fa-folder-open mb-3' style='font-size: 3rem; opacity: 0.2;'></i><br>
                                No bookings found.<br>
                                <a href='packages.php' class='btn btn-download mt-3'>Book Your First Trip</a>
                              </td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>